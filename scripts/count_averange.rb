#!/usr/bin/env ruby

require 'open-uri'
require 'mysql'
require 'date'

begin
  db = Mysql.new('localhost', 'ruby', 'github', 'topr')
rescue Mysql::Error
  puts "Oh noes! Damn... we could not connect to our database. -.-;"
  exit 1
end

def get_averange_direction(db,station)
  result = db.query("SELECT #{station} AS #{station}, COUNT(*) AS ILOSC, DATE_FORMAT(DATE_SYSTEM,'%Y-%m-%d') AS DATE FROM wind_direction WHERE DATE_SYSTEM BETWEEN '#{$yesterday}' AND '#{$today}' GROUP BY #{station} ORDER BY ILOSC DESC LIMIT 1;")

  result = result.fetch_hash["#{station}"].to_s

  if result == "NULL"
    return nil
  else
    return result
  end
end

def get_averange_speed(db,station)
  result = db.query("SELECT AVG(#{station}) AS #{station} FROM wind_speed_averange WHERE DATE_SYSTEM BETWEEN '#{$yesterday}' AND '#{$today}';")
  result = result.fetch_hash["#{station}"].to_f
  
  if result == 0.0
    return 'NULL'
  else
    return result.round(2)
  end
end

$today = (Date.today).strftime("%Y-%m-%d")
$yesterday = (Date.today-1).strftime("%Y-%m-%d")

#$today = "2014-04-17"
#$yesterday = "2014-04-16"

dir_gorycz = get_averange_direction(db,"DIR_GORYCZKOWA")
speed_gorycz = get_averange_speed(db,"GORYCZKOWA")
dir_piec = get_averange_direction(db,"DIR_PIEC_STAWOW")
speed_piec = get_averange_speed(db,"PIEC_STAWOW")
dir_moko = get_averange_direction(db,"DIR_MORSKIE_OKO")
speed_moko = get_averange_speed(db,"MORSKIE_OKO")

db.query("INSERT INTO WIND_AVERANGE (DIR_GORYCZKOWA, AVG_GORYCZKOWA, DIR_PIEC_STAWOW, AVG_PIEC_STAWOW, DIR_MORSKIE_OKO, AVG_MORSKIE_OKO, DATE) values ('#{dir_gorycz}', #{speed_gorycz}, '#{dir_piec}', #{speed_piec}, '#{dir_moko}', #{speed_moko}, '#{$yesterday}');")
