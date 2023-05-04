install.packages("googleway")
library(googleway)
library(dplyr)
library(tidytext)
library(httpuv)
library(jsonlite)
library(RMySQL)
library(tidyr)

## not specifying the api will add the key as your 'default'
## specifying the specific API will only make that key available for that API.
## set_key(key = key, api = "directions")
## clear_keys() -> clear any previously set keys

## key 2
key <- ""
set_key(key = key)
google_keys()

## Stage 1 -----------------

##A search of museums in Berlin
mus <- google_places(search_string = "Museums in Berlin, Germany",
                     key = key)
## View the names of the returned museums, and whether they are open or not
cbind(mus$results$name, mus$results$opening_hours)
View(mus[["results"]])

## ----------------------------------

## Stage 2 ------------------

#creating berlinplaces database
mydb2 = dbConnect(MySQL(), user='root', password='',
                  host='localhost', dbname='berlinplaces')
#STAGE 3 ------
#connecting to freemysqlhosting.net
mydb3 = dbConnect(MySQL(), user='', password='',
                 dbname='', host='sql5.freemysqlhosting.net')

#listing the databases linked to the freemysqlhosting.net account
result3 <- dbGetQuery(mydb3, "show databases;")
result3

# ------------

dbSendQuery(mydb2,"CREATE DATABASE berlinplaces;")

result <- dbGetQuery(mydb2, "show databases;")
result

musinfo2 <- (mus[["results"]])[, c(7,2,12,15)]

##creating table (localhost) w/name, formatted_address,
##rating, user_ratings_total ONLY
dbWriteTable(mydb2, "BerlinMuseums", musinfo2, 
             append = TRUE, row_names = FALSE)
#STAGE 3 ------
##creating table (freemysqlhosting) w/name, formatted_address,
##rating, user_ratings_total ONLY
dbWriteTable(mydb3, "BerlinMuseums", musinfo2, 
             append = TRUE, row_names = FALSE)
---------------
  
## ----------------------------------------

