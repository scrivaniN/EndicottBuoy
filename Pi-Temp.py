"""
Author: Nick Scrivani

Objective of this script is to use a DHT22 sensor to
gather temperature,humidity and date readings using the adafruit libary.
"""

import Adafruit_DHT as dht
import sys
import datetime
from time import sleep
import mysql.connector
import time
#import thread
import schedule

temperatureList = []
humidityList = []
#dblock = False

#s = sched.scheduler(time.time, time.sleep)


#specifies which sensor we are using(we are using dht22)
sensor = dht.DHT22
#connected to gpio 4
pin = '4'

#sleep and get a reading every 3 seconds.
sleepTime = 3


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
    avg = sum(list) / float(len(list))
    return avg

def writeToDB():
    print('writing to database' + 'Time' + str(now.hour) + ':' + str(now.minute))

    
    cnx = mysql.connector.connect(user = 'nick', password = 'Scribbles1$', host = 'ecbuoy.cl7cxw0gh9pq.us-east-2.rds.amazonaws.com', database = 'endicottbuoy')
    cursor = cnx.cursor()
    query = ("INSERT INTO readings (temperature, humidity, date) VALUES (%s, %s, %s)")
    dht_data = (takeAvg(temperatureList),takeAvg(humidityList), now)
    cursor.execute(query,dht_data)

    cnx.commit()
    
    # after we commit we need to reset the list
    temperatureList[:] = [] 
    humidityList[:] = []
    
    cursor.close()
    cnx.close()
    
    
    print('we have written to the database closing connection...')

schedule.every(1).hour.do(writeToDB)



    


while True:
    now = datetime.datetime.now()
    humidity, temperature = readDHT22()
    print('reading values')
    sleep(sleepTime)
    #print('reading  humidity list values')
    print humidityList
    
    
    schedule.run_pending()
    time.sleep(1)
    

    


    
    




