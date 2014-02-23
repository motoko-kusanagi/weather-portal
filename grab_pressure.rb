#!/usr/bin/env ruby

require 'open-uri'
require 'nokogiri'
require 'mysql'

def text_parse(what)
  return what.gsub("Ciśnienie: ","").gsub("hPa","").to_f
end

url = Nokogiri::HTML(open("http://tpn.pl/zwiedzaj/pogoda"),'UTF-8')
pressure = url.css("div[class='weather'] span[class='pressure']")

begin
  db = Mysql.new('localhost', 'ruby', 'github', 'topr')
rescue Mysql::Error
  puts "Oh noes! Damn... we could not connect to our database. -.-;"
  exit 1
end

datetime = Time.now.utc.to_s.gsub(" UTC","")

db.query("INSERT INTO pressure (KASPROWY_WIERCH, LOMNICA, DATE_SYSTEM) VALUES (#{text_parse(pressure[20].text)}, #{text_parse(pressure[30].text)}, '#{datetime}');")
