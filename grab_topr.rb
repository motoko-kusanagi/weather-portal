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

datetime = Time.now.utc.to_s.gsub(" UTC","")
xml_date = xml_date.to_s

def xml_parse(what)
  return what.gsub('"',"").gsub("[","").gsub("]","")
end

begin
  db = Mysql.new('localhost', 'ruby', 'github', 'topr')
rescue Mysql::Error
  puts "Oh noes! Damn... we could not connect to our database. -.-;"
  exit 1
end

db.query("INSERT INTO temperature (GORYCZKOWA, PIEC_STAWOW, MORSKIE_OKO, DATE_XML, DATE_SYSTEM) VALUES (#{xml_parse(xml_temperature.to_s)}, '#{xml_date}', '#{datetime}');")
db.query("INSERT INTO wind_speed_averange (GORYCZKOWA, PIEC_STAWOW, MORSKIE_OKO, DATE_XML, DATE_SYSTEM) VALUES (#{xml_parse(xml_windAVG.to_s)}, '#{xml_date}', '#{datetime}');")
db.query("INSERT INTO wind_speed_maximum (GORYCZKOWA, PIEC_STAWOW, MORSKIE_OKO, DATE_XML, DATE_SYSTEM) VALUES (#{xml_parse(xml_windMAX.to_s)}, '#{xml_date}', '#{datetime}');")
db.query("INSERT INTO wind_direction (GORYCZKOWA, PIEC_STAWOW, MORSKIE_OKO, DATE_XML, DATE_SYSTEM) VALUES (#{xml_parse(xml_windDIR.to_s)}, '#{xml_date}', '#{datetime}');")
