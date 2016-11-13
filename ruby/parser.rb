# Парсим json файл нашего биткоин-адреса и узнаем 
# сколько получено satoshi по данному адресу

require 'json'
require 'net/http'
require 'uri'

url = ARGV[0]                    # получаем url json файла для парсинга
def open(url)
  Net::HTTP.get(URI.parse(url))
end

file = open(url)
data_hash = JSON.parse(file)
puts data_hash['total_received'] # по ключу total_received узнаем сколько получено средств на биткоин-адрес
