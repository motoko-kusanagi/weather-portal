#!/usr/bin/env ruby

require 'open-uri'
require 'nokogiri'
require 'mysql'

url = Nokogiri::HTML(open("http://www.webkamery.sk/webkamera-live/55-lomnicky-stit"),'utf-8')
lomnica = url.css("div[class='right_webkamera_info'] span[class='value']")
puts lomnica[0].text.gsub(" °C","")

#db.query("INSERT INTO temperature (GORYCZKOWA, PIEC_STAWOW, MORSKIE_OKO, DATE_XML, DATE_SYSTEM) VALUES (#{xml_parse(xml_temperature.to_s)}, '#{xml_date}', '#{datetime}');")

