"""
Author: Nick Scrivani

Objective of this script is to use a DHT22,DS18B20 and anemometer to
gather temperature,humidity,water temperature, wind speed and date readings using the adafruit libary .
"""

import Adafruit_DHT as dht
import sys
import datetime
from time import sleep
import mysql.connector
import time
import schedule
import glob
import os
import Adafruit_ADS1x15

temperatureList = []
humidityList = []
waterList = []
windList = []


def readWindSpeed():
  adc = Adafruit_ADS1x15.ADS1115()

  GAIN = 1

  print("Readng ADS1x15 values, press Ctrl-C to quit...")

  print('| {0:>6} | {1:>6} | {2:>6} | {3:>6} |'.format(*range(4)))
  print('-' * 37)
  #Main loop
  start = time.time()
  #windList = []
  counter = 0
  average = 0
  sensorVoltage = 0
  windSpeed = 0
  voltageConversionConstant = .00012523
  voltageMin = 0.4
  windSpeedMin = 0
  voltageMax = 2.0
  windSpeedMax = 32

  while time.time() < start + 10:
    values = [0]*4
    for i in range(4):
      values[i] = adc.read_adc(i, gain=GAIN)
      print('| {0:>6} | {1:>6} | {2:>6} | {3:>6} |'.format(*values))
      average += values[0]
      counter += 1
      time.sleep(0.5)

  average /= counter
  sensorVoltage = average * voltageConversionConstant
  if sensorVoltage <= voltageMin:
    windSpeed = 0

  else:
    windSpeed = (sensorVoltage - voltageMin)*windSpeedMax/(voltageMax/voltageMin)*2.23694


  windList.append(windSpeed)
  #return windSpeed
  print(average)
  print(windSpeed)


#specifies which sensor we are using(we are using dht22)
sensor = dht.DHT22
#connected to gpio 22
pin = '22'

#sleep and get a reading every 10 minutes.
sleepTime = 3

# Initialize the GPIO Pins
os.system('modprobe w1-gpio')  # Turns on the GPIO module
os.system('modprobe w1-therm') # Turns on the Temperature module

# Finds the correct device file that holds the temperature data
base_dir = '/sys/bus/w1/devices/'
device_folder = glob.glob(base_dir + '28*')[0]
device_file = device_folder + '/w1_slave'

# A function that reads the sensors data
def read_temp_raw():
  f = open(device_file, 'r') # Opens the temperature device file
  lines = f.readlines() # Returns the text
  f.close()
  return lines
 
# Convert the value of the sensor into a temperature
def read_temp():
  lines = read_temp_raw() # Read the temperature 'device file'
 
  #While the first line does not contain 'YES', wait for 0.2s
  # and then read the device file again.
  while lines[0].strip()[-3:] != 'YES':
    time.sleep(0.2)
    lines = read_temp_raw()
 
  # Look for the position of the '=' in the second line of the
  # device file.
  equals_pos = lines[1].find('t=')
 
  # If the '=' is found, convert the rest of the line after the
  # '=' into degrees Celsius, then degrees Fahrenheit
  if equals_pos != -1:
    temp_string = lines[1][equals_pos+2:]
    temp_c = float(temp_string) / 1000.0
    temp_f = temp_c * 9.0 / 5.0 + 32.0
    waterList.append(temp_f)
    return temp_c, temp_f

def readDHT22():
    #get a new reading 
    humidity,temperature = dht.read_retry(sensor, pin)
    #convert temperature to Fahrenheit
    temperature = temperature *9/5.0 + 32
    #if there is a reading display it. if not print failer message
    if humidity is not None and temperature is not None:
        print('Temp={0:0.1f}* Humidity={1:0.1f}%'.format(temperature, humidity))
        temperatureList.append(temperature)
        humidityList.append(humidity)
        return(temperature, humidity)
    else:
        print('Failed to get reading, Try again!')
        sys.exit(1)

def takeAvg(list):
    
    if len(list) > 0:
      return sum(list) / float(len(list))
    else:
      return 0

def writeToDB():
    print('writing to database' + 'Time' + str(now.hour) + ':' + str(now.minute))

    
    cnx = mysql.connector.connect(user = ' ', password = ' ', host = 'ecbuoy.cl7cxw0gh9pq.us-east-2.rds.amazonaws.com',
    database = 'endicottbuoy')
    cursor = cnx.cursor()
    query = ("INSERT INTO readings (temperature, humidity, date, water_temp, wind_speed) VALUES (%s, %s, %s, %s, %s)")
    dht_data = (takeAvg(temperatureList),takeAvg(humidityList), now, takeAvg(waterList), takeAvg(windList))
    cursor.execute(query,dht_data)

    cnx.commit()
    
    # after we commit we need to reset the list
    temperatureList[:] = [] 
    humidityList[:] = []
    waterList[:] = []
    windList[:] = []
    
    cursor.close()
    cnx.close()
    
    
    print('we have written to the database closing connection...')

#tell the scheduler to write to the database every hour.
schedule.every(1).minutes.do(writeToDB)

while True:
    now = datetime.datetime.now()
    #print(read_temp())
    #humidity, temperature = readDHT22()
    readWindSpeed()
    print('reading values')
    sleep(sleepTime)
    #print('reading  humidity list values')
    print humidityList
    print waterList
    print windList
    
    #if there is a schedule pending run the task.
    schedule.run_pending()
    time.sleep(1)
    

    


    
    




