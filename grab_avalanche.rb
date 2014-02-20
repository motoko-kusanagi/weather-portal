#!/usr/bin/env ruby

require 'open-uri'
require 'nokogiri'
require 'mysql'

url = Nokogiri::HTML(open("http://www.topr.pl/index.php?option=com_content&task=view&id=130&Itemid=119"),'ISO-8859-2')

av_level = url.css('div.imgstopien img').map { |link| link['alt'] }
av_level = av_level.to_s

av_tend = url.css('div.tendency img').map { |link| link['alt'] }
av_tend = av_tend.to_s.split(" ")
av_tend = av_tend[1].to_s.gsub('"',"").gsub("]","").gsub(".","")

if "#{av_tend}" == "rosn±ca" 
  puts "#{av_level.chars[2].to_i}+"
elsif "#{av_tend}" == "malej±ca"
  puts "#{av_level.chars[2].to_i}-"
elsif "#{av_tend}" == "stala"
  puts "#{av_level.chars[2].to_i}"
else
  puts "NULL"
end

