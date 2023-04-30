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
key <- "AIzaSyDj2asrWPBFVRfJ63jKseRbe8IrvYTtRhA"
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
mydb2 = dbConnect(MySQL(), user='root', password='t2kAx7#uSG$1',
                  host='localhost', dbname='berlinplaces')
#STAGE 3 ------
#connecting to freemysqlhosting.net
mydb3 = dbConnect(MySQL(), user='sql5475001', password='EkPC5F21V8',
                 dbname='sql5475001', host='sql5.freemysqlhosting.net')

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

dbRemoveTable(mydb2, "BerlinMuseums2")

dbListTables(mydb2)
dbReadTable(mydb2, "BerlinMuseums")

names(mus[["results"]])

## name, formatted_address, rating, user_ratings_total
(mus[["results"]])[1:3, c(7,2,12,15)]


newgenre
us100new<-us100[,c(1,3)] ##artistName and name columns
us100Final<-cbind(us100new,newgenre) ##column binding of artistName, name, & genre columns

musnew <- mus[,c(1,3)]

dbWriteTable(mydb, "US100NEW", us100Final, append = TRUE)

dfMel2Syd <- google_directions(origin = "Melbourne, Australia",
                        destination = "Sydney, Australia",
                        key = key,
                        mode = "driving",
                        alternatives = FALSE,
                        simplify = TRUE)
pl <- direction_polyline(dfMel2Syd)
pl

polyline <- "fnxeFwaxsZao@dlCkfAnZyhFoIk{A`_@g{@fqB`CfkCqoByAacAx[mcA}vBkp@oeNynG_k@wvDjc@s~A|kEmxD~jAiqEia@ayEmw@wzDycBspEo|@{uDu_Eg`DymAmjBbSkhCSwxBuvAkzBmlBs|EcLe}ClGcnDciAqdLcbBaoK}dC_rKhMkiC}}Ao~@{g@}HqkCm\\yoCwaCg~Baj@}nB}nCciAgdD}qE_fDmeDevFwhR}eFeeRkcCidEsb@s`FjZaiDe}Ay`BinDamB_vEi|HysGi{F}qBe_G{iDypLgl@k~Jw{CcpJre@sjFqdDqlKgpCwrEeuAqEw`CexH_nCo~Iw{Ai~KioHq~EigB{aL}oCuyEq~D{n@wlAhm@y}Cue@cgOc~KknEypDa|B{dGaHkaIuXceFueAkvDahD}_CsmAsfCmrB_tDenAsgFzKq~FtvBupFfv@u}E|JiyDkfAgrCutCwgB{}De~FyaJwmDqjKcwAkEcbHlH}`E}z@}sAEg_GkdBenC_yDu{BaqCst@e}@ufBmjAeyCslB{NgxAc~AuuAgkC_yDkjCayFox@o~BuqGq{A_eGyu@o`Fi|JuoMykBwsCm_Eqo@khHivDmtE_bCalEw~DiqBarCioGwlDuoDllBiuD~AuqB}jHobCiqDgeEq{EyyEcjG_yB_sAg|Agb@cZcyB}JwgFeaBkpB_bBgyD_@kgE{d@gdHcgCuwCscAwqEwlEyzDi|CyiAe~EkVebD{r@a{@w|Cu~Bc}AueAy_BsnBpMq}AdNa[ujAau@opC}|AorCs{@gmE_jCa|DmvBm~AicBekCdZqxGyp@q`H|GahDckAuiIpKgdHlf@g~MtbAonFcoBk|DukCagCqr@crDpDugO|~EukKwPipEljBsoDr|@aqEzFoeGic@ykCoDmhD}_DyoLmkA}rDvDasFwU_kDnoAiaGzlCkzN}a@utPsqAycGp\\goLkB}yE}gBezBsbAcsH_IupKauA{yDisC{_Aud@s|IpbAuhDeMybNetA}kHmhEcsFcmCcyFiiC_jDw[}qDscBsrEqq@wuIyrGuzGgjGarD{jEwqD_lDqaAki@cnAmxA{}D_mCmsOqlAsxEqgF{~F{wHodFgpCo{FihDybFmdGsiCgxH{kI}iFquC{pFyfCmuD_aAmaDc~Bmt@ipCm}A}}@_wCk]}_B_zBknCezCwoBaZ{w@mzBih@oyBbTadDfHozHkKocIgi@{vQnhA{hDgz@opDaoAsiBahDcI_uCuKuYht@"
df <- decode_pl(polyline)
head(df)

encode_pl(lat = df$lat, lon = df$lon)


df <- google_distance(origins = list(c("Melbourne Airport, Australia"),
                                     c("MCG, Melbourne, Australia"),
                                     c(52.5145033,13.485327)),
                      destinations = c("Portsea, Melbourne, Australia"),
                      key = key)
head(df)

df2 <- google_distance(origins = list(c("Tierpark Berlin, Berlin, Germany"),
                                      c("Spreepark, Berlin, Germany"),
                                      c(-37.81659, 144.9841)),
                       destinations = c("Kaiser Wilhelm Memorial Church, Berlin, Germany"),
                       key = key)
head(df2)
