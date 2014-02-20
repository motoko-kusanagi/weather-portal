#!/usr/bin/env ruby

require 'open-uri'
require 'nokogiri'
require 'mysql'

av_level = Nokogiri::HTML(open("http://www.topr.pl/index.php?option=com_content&task=view&id=130&Itemid=119"),'utf-8')
av_level = av_level.css("div.imgstopien")
puts av_level

#av_level = Nokogiri::HTML(open("http://www.topr.pl/index.php?option=com_content&task=view&id=130&Itemid=119"),'utf-8')
#puts av_level.xpath('//img/alt')
