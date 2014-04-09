#!/usr/bin/env ruby

require 'open-uri'
require 'nokogiri'
require 'mysql'

def extract_pressure(what)
  what = what[1].to_a
  what = what[3].to_a
  return what[1]
end

def pressure_value(what)
  return what.gsub("Ciśnienie: ","").gsub("hPa","").to_f
end

url = Nokogiri::HTML(open("http://tpn.pl/zwiedzaj/pogoda"),'UTF-8')
url_krk = Nokogiri::HTML(open("http://www.pogoda.krakow.pl/"),'UTF-8')

pressure = url.css("div[class='weather'] span[class='pressure']")
pressure_krk = url_krk.css("div[class='data_up'] span")

begin
  db = Mysql.new('localhost', 'ruby', 'github', 'topr')
rescue Mysql::Error
  puts "Oh noes! Damn... we could not connect to our database. -.-;"
  exit 1
end

datetime = Time.now.utc.to_s.gsub(" UTC","")

weather = url.css("table[class='meteotable']").each_with_object({}) { |m,h| h[m.css(".meteostation").text] = m.css(".meteocell:first").css("td > span").each_with_object({}) { |e,h| h[e["class"]]=e.text }}.to_a

db.query("INSERT INTO pressure (ZAKOPANE, KASPROWY_WIERCH, LOMNICA, KRAKOW, DATE_SYSTEM) VALUES (#{pressure_value(extract_pressure(weather[0]))}, #{pressure_value(extract_pressure(weather[4]))}, #{pressure_value(extract_pressure(weather[6]))}, '#{pressure_krk.text.gsub("hPa*","").to_f}', '#{datetime}');")
