import mysql.connector
import requests
import json
import datetime

api_key = "da6a0807c524b6cf549757a7ceadc7ba"
units = "metric"
lat = "52.5200"
lon = "13.4050"
url = "https://api.openweathermap.org/data/2.5/onecall?lat=%s&lon=%s&appid=%s&units=%s" % (lat, lon, api_key, units)

response = requests.get(url)
data = json.loads(response.text)




db = mysql.connector.connect(
    #host="localhost",
    #user="root",
    host="sql5.freemysqlhosting.net",
    user="",
    password="",
    database=""
)

mycursor = db.cursor()
#mycursor.execute("CREATE DATABASE BerlinWeather")


#mycursor.execute("CREATE TABLE CurrentWeather (Name VARCHAR(50), Value smallint, CurrentWeatherID int PRIMARY KEY AUTO_INCREMENT)")

# Creates currentweather Table in the Berlin Weather Database

epochtime = data["current"]["dt"]



#print(ts.strftime('%H:%M:$S'))

current_temp = data["current"]["temp"]
current_ = data["current"]["temp"]
current_feels_like = data["current"]["feels_like"]
current_sunrise = datetime.datetime.fromtimestamp(data["current"]["sunrise"])
current_sunrise_converted = current_sunrise.strftime('%H:%M:%S')
current_sunset = datetime.datetime.fromtimestamp(data["current"]["sunset"])
current_sunset_converted = current_sunset.strftime('%H:%M:%S')
current_pressure = data["current"]["pressure"]
current_humidity = data["current"]["humidity"]
current_dew_point = data["current"]["dew_point"]
current_uvi = data["current"]["uvi"]
current_clouds = data["current"]["clouds"]
current_visibility = data["current"]["visibility"]
current_wind_speed = data["current"]["wind_speed"]
current_wind_deg = data["current"]["wind_deg"]
current_temp = data["current"]["temp"]
current_main = data["current"]["weather"][0]["main"]
current_description = data["current"]["weather"][0]["description"]
current_icon = data["current"]["weather"][0]["icon"]

mycursor.execute("REPLACE INTO CurrentWeather (CurrentWeatherID,Name,Value) VALUES (%s,%s,%s)", (1,"Temperature",current_temp))
mycursor.execute("REPLACE INTO CurrentWeather (CurrentWeatherID,Name,Value) VALUES (%s,%s,%s)", (2,"Feels Like", current_feels_like))
mycursor.execute("REPLACE INTO CurrentWeather (CurrentWeatherID,Name,Value) VALUES (%s,%s,%s)", (3,"Sunrise",current_sunrise_converted))
mycursor.execute("REPLACE INTO CurrentWeather (CurrentWeatherID,Name,Value) VALUES (%s,%s,%s)", (4,"Sunset",current_sunset_converted))
mycursor.execute("REPLACE INTO CurrentWeather (CurrentWeatherID,Name,Value) VALUES (%s,%s,%s)", (5,"Pressure",current_pressure))
mycursor.execute("REPLACE INTO CurrentWeather (CurrentWeatherID,Name,Value) VALUES (%s,%s,%s)", (6,"Humidity",current_humidity))
mycursor.execute("REPLACE INTO CurrentWeather (CurrentWeatherID,Name,Value) VALUES (%s,%s,%s)", (7,"Dew Point",current_dew_point))
mycursor.execute("REPLACE INTO CurrentWeather (CurrentWeatherID,Name,Value) VALUES (%s,%s,%s)", (8,"UVI",current_uvi))
mycursor.execute("REPLACE INTO CurrentWeather (CurrentWeatherID,Name,Value) VALUES (%s,%s,%s)", (9,"Clouds",current_clouds))
mycursor.execute("REPLACE INTO CurrentWeather (CurrentWeatherID,Name,Value) VALUES (%s,%s,%s)", (10,"Visibility", current_visibility))
mycursor.execute("REPLACE INTO CurrentWeather (CurrentWeatherID,Name,Value) VALUES (%s,%s,%s)", (11,"Wind Speed", current_wind_speed))
mycursor.execute("REPLACE INTO CurrentWeather (CurrentWeatherID,Name,Value) VALUES (%s,%s,%s)", (12,"Wind Degree", current_wind_deg))
mycursor.execute("REPLACE INTO CurrentWeather (CurrentWeatherID,Name,Value) VALUES (%s,%s,%s)", (13,"Main", current_main))
mycursor.execute("REPLACE INTO CurrentWeather (CurrentWeatherID,Name,Value) VALUES (%s,%s,%s)", (14,"Description", current_description))
mycursor.execute("REPLACE INTO CurrentWeather (CurrentWeatherID,Name,Value) VALUES (%s,%s,%s)", (15,"Icon", current_icon))

db.commit()
#mycursor.execute()
