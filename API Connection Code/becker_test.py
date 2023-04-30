import requests
import json
req=requests.get("https://api.covid19api.com/country/germany/status/confirmed/live")
response =req.json()
for item in response:
    print('')
    print(item['Country'])
    print(item['Date'])
    print(item['Cases'])
    print(item['Status'])


out_file = open("myfile.json", "w")

json.dump(response, out_file, indent=6)

out_file.close()
