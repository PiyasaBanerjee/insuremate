import urllib.request
import re

req = urllib.request.Request(
    'https://www.policybazaar.com/', 
    headers={'User-Agent': 'Mozilla/5.0'}
)
try:
    html = urllib.request.urlopen(req).read().decode('utf-8')
    images = re.findall(r'(https?://[^\'\"\s]+\.png)', html)
    for img in set(images):
        if 'tw' in img.lower() or 'bike' in img.lower() or 'scoot' in img.lower():
            print("FOUND: " + img)
except Exception as e:
    print(e)
