#!/usr/bin/env ruby

require 'open-uri'
require 'nokogiri'
require 'mysql'

xml = Nokogiri::XML(open("http://www.test.tatrynet.pl/pogoda/weatherMiddleware_v1.0/xml/lokalizacje1.xml"),'utf-8')
xml_date = xml.xpath('//dateTimeStr').map { |node| node.text }.first
xml_place = xml.xpath('//nazwa').map { |node| node.text }
xml_temperature = xml.xpath('//temperatura/aktualna').map { |node| node.text }
xml_windAVG = xml.xpath('//wiatr/silaAvg').map { |node| node.text }
xml_windMAX = xml.xpath('//wiatr/silaMax').map { |node| node.text }
xml_windDIR = xml.xpath('//wiatr/kierunek').map { |node| node.text }

url = Nokogiri::HTML(open("http://www.webkamery.sk/webkamera-live/55-lomnicky-stit"),'utf-8')
lomnica = url.css("div[class='right_webkamera_info'] span[class='value']")
lomnica = lomnica[0].text.gsub(" °C","").gsub(",",".")

url_krk = Nokogiri::HTML(open("http://zdpk.krakow.pl/pub/meteo/zdpk01/Current_Vantage.htm"),'UTF-8')
url_krk = url_krk.css("tr font[color='#3366FF']")
krakow = url_krk[0].text.gsub("°C","")

datetime = Time.now.utc.to_s.gsub(" UTC","")
xml_date = xml_date.to_s

def xml_parse(what)
  return what.gsub('"',"").gsub("[","").gsub("]","")
end

def check_value(what)
  if what == ""
    return "NULL"
  else
    return what
  end
end

def wind_direction(value)
  if value == 0.0
    return "NULL"
    exit
  end

  if value > 22 && value <= 67
    return "NE"
  elseif value > 67 && value <= 122
    return "E"
  elseif value > 112 && value <= 157
    return "SE"
  elseif value > 157 && value <= 202
    return "S"
  elseif value > 202 && value <= 247
    return "SW"
  elseif value > 247 && value <= 292
    return "W"
  elseif value > 292 && value <= 337
    return "NW"
  end
end

begin
  db = Mysql.new('localhost', 'ruby', 'github', 'topr')
rescue Mysql::Error
  puts "Oh noes! Damn... we could not connect to our database. -.-;"
  exit 1
end

#temp_values = xml_parse(xml_temperature.to_s).split(",")
#goryczkowa = check_value(temp_values[0].gsub(" ","")).to_s
#piec_stawow = check_value(temp_values[1].gsub(" ","")).to_s
#morskie_oko = check_value(temp_values[2].gsub(" ","")).to_s
#db.query("INSERT INTO temperature (GORYCZKOWA, PIEC_STAWOW, MORSKIE_OKO, LOMNICKY_STIT, KRAKOW, DATE_XML, DATE_SYSTEM) VALUES (#{goryczkowa}, #{piec_stawow}, #{morskie_oko}, '#{lomnica.to_s}', '#{krakow}', '#{xml_date}', '#{datetime}');")

#wind_avg_values = xml_parse(xml_windAVG.to_s).split(",")
#goryczkowa = check_value(wind_avg_values[0].gsub(" ","")).to_s
#piec_stawow = check_value(wind_avg_values[1].gsub(" ","")).to_s
#morskie_oko = check_value(wind_avg_values[2].gsub(" ","")).to_s
#db.query("INSERT INTO wind_speed_averange (GORYCZKOWA, PIEC_STAWOW, MORSKIE_OKO, DATE_XML, DATE_SYSTEM) VALUES (#{goryczkowa}, #{piec_stawow}, #{morskie_oko}, '#{xml_date}', '#{datetime}');")

#wind_max_values = xml_parse(xml_windMAX.to_s).split(",")
#goryczkowa = check_value(wind_max_values[0].gsub(" ","")).to_s
#piec_stawow = check_value(wind_max_values[1].gsub(" ","")).to_s
#morskie_oko = check_value(wind_max_values[2].gsub(" ","")).to_s
#db.query("INSERT INTO wind_speed_maximum (GORYCZKOWA, PIEC_STAWOW, MORSKIE_OKO, DATE_XML, DATE_SYSTEM) VALUES (#{goryczkowa}, #{piec_stawow}, #{morskie_oko}, '#{xml_date}', '#{datetime}');")


wind_dir_values = xml_parse(xml_windDIR.to_s).split(",")
goryczkowa = check_value(wind_dir_values[0].gsub(" ","")).to_s
dir_goryczkowa = wind_direction(wind_dir_values[0].gsub(" ","").to_f).to_s
piec_stawow = check_value(wind_dir_values[1].gsub(" ","")).to_s
dir_piec_stawow = wind_direction(wind_dir_values[1].gsub(" ","").to_f).to_s
morskie_oko = check_value(wind_dir_values[2].gsub(" ","")).to_s
dir_morskie_oko = wind_direction(wind_dir_values[2].gsub(" ","").to_f).to_s
db.query("INSERT INTO wind_direction (GORYCZKOWA, DIR_GORYCZKOWA, PIEC_STAWOW, DIR_PIEC_STAWOW, MORSKIE_OKO, DIR_MORSKIE_OKO, DATE_XML, DATE_SYSTEM) VALUES (#{goryczkowa}, '#{dir_goryczkowa}', #{piec_stawow}, '#{dir_piec_stawow}', #{morskie_oko}, '#{dir_morskie_oko}', '#{xml_date}', '#{datetime}');")
