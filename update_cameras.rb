#!/usr/bin/env ruby

require 'net/http'
require 'pathname'

def get_pic(location)
  url = URI.parse(location)
  req = Net::HTTP.new(url.host, url.port)
  res = req.request_head(url.path)
  return res.code
end


links = []

# topr / moko
links << "http://kamery.topr.pl/moko/moko_01.jpg"
links << "http://kamery.topr.pl/moko/moko_02.jpg"
# topr / piec stawow
links << "http://kamery.topr.pl/stawy2/stawy2.jpg"
links << "http://kamery.topr.pl/stawy1/stawy1.jpg"
# topr / kasprowy
links << "http://kamery.topr.pl/gasienicowa/gasie.jpg"
links << "http://kamery.topr.pl/goryczkowa/gorycz.jpg"
# topr / chocholowska
links << "http://kamery.topr.pl/chocholowska/chocholow.jpg"

# download photo
links.each do |camera|
   File.write("/var/www/chart/cameras/#{File.basename(camera)}", Net::HTTP.get(URI.parse(camera))) if get_pic(camera) == "200"
end
