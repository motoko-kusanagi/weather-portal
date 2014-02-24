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

begin
  db = Mysql.new('localhost', 'ruby', 'github', 'topr')
rescue Mysql::Error
  puts "Oh noes! Damn... we could not connect to our database. -.-;"
  exit 1
end

temp_values = xml_parse(xml_temperature.to_s).split(",")
goryczkowa = check_value(temp_values[0].gsub(" ","")).to_s
piec_stawow = check_value(temp_values[1].gsub(" ","")).to_s
morskie_oko = check_value(temp_values[2].gsub(" ","")).to_s
db.query("INSERT INTO temperature (GORYCZKOWA, PIEC_STAWOW, MORSKIE_OKO, LOMNICKY_STIT, DATE_XML, DATE_SYSTEM) VALUES (#{goryczkowa}, #{piec_stawow}, #{morskie_oko}, '#{lomnica.to_s}', '#{xml_date}', '#{datetime}');")

wind_avg_values = xml_parse(xml_windAVG.to_s).split(",")
goryczkowa = check_value(wind_avg_values[0].gsub(" ","")).to_s
piec_stawow = check_value(wind_avg_values[1].gsub(" ","")).to_s
morskie_oko = check_value(wind_avg_values[2].gsub(" ","")).to_s
db.query("INSERT INTO wind_speed_averange (GORYCZKOWA, PIEC_STAWOW, MORSKIE_OKO, DATE_XML, DATE_SYSTEM) VALUES (#{goryczkowa}, #{piec_stawow}, #{morskie_oko}, '#{xml_date}', '#{datetime}');")

wind_max_values = xml_parse(xml_windMAX.to_s).split(",")
goryczkowa = check_value(wind_max_values[0].gsub(" ","")).to_s
piec_stawow = check_value(wind_max_values[1].gsub(" ","")).to_s
morskie_oko = check_value(wind_max_values[2].gsub(" ","")).to_s
db.query("INSERT INTO wind_speed_maximum (GORYCZKOWA, PIEC_STAWOW, MORSKIE_OKO, DATE_XML, DATE_SYSTEM) VALUES (#{goryczkowa}, #{piec_stawow}, #{morskie_oko}, '#{xml_date}', '#{datetime}');")

wind_dir_values = xml_parse(xml_windDIR.to_s).split(",")
goryczkowa = check_value(wind_dir_values[0].gsub(" ","")).to_s
piec_stawow = check_value(wind_dir_values[1].gsub(" ","")).to_s
morskie_oko = check_value(wind_dir_values[2].gsub(" ","")).to_s
db.query("INSERT INTO wind_direction (GORYCZKOWA, PIEC_STAWOW, MORSKIE_OKO, DATE_XML, DATE_SYSTEM) VALUES (#{goryczkowa}, #{piec_stawow}, #{morskie_oko}, '#{xml_date}', '#{datetime}');")
