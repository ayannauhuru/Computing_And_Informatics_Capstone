import json
import mysql.connector
json_data=open("myfile.json").read()
json_obj=json.loads(json_data)

db = mysql.connector.connect(
    host="sql5.freemysqlhosting.net",
    user="",
    password="",
    database=""
)


mycursor = db.cursor()

#mycursor.execute("CREATE TABLE Covid (Country VARCHAR(50), DateOf VARCHAR(50), Cases VARCHAR(50))")

for item in json_obj:
  Country=item.get("Country")
  Date = item.get("Date")
  Cases = item.get("Cases")
  mycursor.execute("insert into Covid(Country,Date,Cases) value(%s,%s,%s)",(Country,Date,Cases))
db.commit()
db.close()

