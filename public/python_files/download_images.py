from bs4 import BeautifulSoup
import requests
import re
import urllib2
import os
import sys


def get_soup(url,header):
  return BeautifulSoup(urllib2.urlopen(urllib2.Request(url,headers=header)))

image_type = "Action"
# you can change the query for the image  here  
query = sys.argv[1]
query= query.split()
query='+'.join(query)
url="https://www.google.co.in/search?q="+query+"&source=lnms&tbm=isch"
header = {'User-Agent': 'Mozilla/5.0'} 
soup = get_soup(url,header)
images = [a['src'] for a in soup.find_all("img", {"src": re.compile("gstatic.com")})]
os.system("mkdir "+sys.argv[2]+'/'+query)
#print images
DIR = ''
for img in images:
  raw_img = urllib2.urlopen(img).read()
  #add the directory for your image here 
  DIR=sys.argv[2]+'/'+query+'/'
  cntr = len([i for i in os.listdir(DIR) if image_type in i]) + 1
  f = open(DIR + image_type + "_"+ str(cntr)+".jpg", 'wb')
  f.write(raw_img)
  f.close()
print DIR