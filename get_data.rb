#!/usr/bin/env ruby

require 'open-uri'
require 'nokogiri'
require 'mysql'

weather = Struct.new(:name, :temp, :wind, :date)
valley = []

file_temperature = File.open("temp.txt", "w")

xml = Nokogiri::XML(open("http://www.test.tatrynet.pl/pogoda/weatherMiddleware_v1.0/xml/lokalizacje1.xml"),'utf-8')
xml_date = xml.xpath('//dateTimeStr').map { |node| node.text }.first
xml_place = xml.xpath('//nazwa').map { |node| node.text }
xml_temperature = xml.xpath('//temperatura/aktualna').map { |node| node.text }
xml_wind = xml.xpath('//wiatr/silaAvg').map { |node| node.text }

for i in 0..xml_place.length-1
  valley[i] = [weather.new(xml_place[i],xml_temperature[i],xml_wind[i],xml_date)]
end

def xml_parse(what)
  return what.gsub('"',"").gsub("[","").gsub("]","")
end

xml_parse(xml_temperature.to_s)
puts "#{xml_parse(xml_temperature.to_s)}"

begin
  db = Mysql.new('localhost', 'ruby', 'github', 'topr')
#  db = Mysql.new('localhost', 'ruby', 'github')
rescue Mysql::Error
  puts "Oh noes! Damn... we could not connect to our database. -.-;"
  exit 1
end

  db.query("INSERT INTO temperature (GORYCZKOWA, PIEC_STAWOW, MORSKIE_OKO) VALUES (#{xml_parse(xml_temperature.to_s)});")
