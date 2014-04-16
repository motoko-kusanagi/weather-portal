#!/usr/bin/env ruby

require 'open-uri'
require 'nokogiri'
require 'mysql'
require 'pathname'

url = Nokogiri::HTML(open("http://www.topr.pl/index.php?option=com_content&task=view&id=130&Itemid=119"),'ISO-8859-2')

av_level = url.css('div.imgstopien img').map { |link| link['alt'] }
av_level = av_level.to_s

av_tend = url.css("div[class='tendency'] img").map { |link| link['src'] }
av_tend = File.basename("#{av_tend}").gsub('.gif"]',"")

begin
  db = Mysql.new('localhost', 'ruby', 'github', 'topr')
rescue Mysql::Error
  puts "Oh noes! Damn... we could not connect to our database. -.-;"
  exit 1
end

xml = Nokogiri::XML(open("http://www.test.tatrynet.pl/pogoda/weatherMiddleware_v1.0/xml/lokalizacje1.xml"),'utf-8')
xml_date = xml.xpath('//dateTimeStr').map { |node| node.text }.first

if "#{av_tend}" == "rosnaca" 
  db.query("INSERT INTO avalanche_level (LEVEL, TEND, DATE_XML, DATE_SYSTEM) VALUES (#{av_level.chars[2].to_i}, '+', '#{xml_date.to_s}', '#{Time.now.utc.to_s.gsub(" UTC","")}');")
elsif "#{av_tend}" == "malejaca"
  db.query("INSERT INTO avalanche_level (LEVEL, TEND, DATE_XML, DATE_SYSTEM) VALUES (#{av_level.chars[2].to_i}, '-', '#{xml_date.to_s}', '#{Time.now.utc.to_s.gsub(" UTC","")}');")  
elsif "#{av_tend}" == "stala"
  db.query("INSERT INTO avalanche_level (LEVEL, TEND, DATE_XML, DATE_SYSTEM) VALUES (#{av_level.chars[2].to_i}, ' ', '#{xml_date.to_s}', '#{Time.now.utc.to_s.gsub(" UTC","")}');")
else
  db.query("INSERT INTO avalanche_level (LEVEL, TEND, DATE_XML, DATE_SYSTEM) VALUES (#{av_level.chars[2].to_i}, NULL, '#{xml_date.to_s}', '#{Time.now.utc.to_s.gsub(" UTC","")}');")
end
