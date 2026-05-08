import urllib.request
import base64

req = urllib.request.Request(
    'https://static.pbcdn.in/cdn/images/home-v1/tw.png',
    headers={
        'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
        'Referer': 'https://www.policybazaar.com/',
        'Accept': 'image/avif,image/webp,image/apng,image/svg+xml,image/*,*/*;q=0.8'
    }
)
try:
    with urllib.request.urlopen(req) as response:
        img_data = response.read()
        b64 = base64.b64encode(img_data).decode('utf-8')
        print("data:image/png;base64," + b64)
except Exception as e:
    print(f"Failed with tw.png: {e}")

req_bike = urllib.request.Request(
    'https://static.pbcdn.in/cdn/images/home-v1/bike.png',
    headers={
        'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
        'Referer': 'https://www.policybazaar.com/',
        'Accept': 'image/avif,image/webp,image/apng,image/svg+xml,image/*,*/*;q=0.8'
    }
)
try:
    with urllib.request.urlopen(req_bike) as response:
        img_data = response.read()
        b64 = base64.b64encode(img_data).decode('utf-8')
        with open('b64.txt', 'w') as f:
            f.write("data:image/png;base64," + b64)
        print("WROTE BIKE.PNG BASE64 TO b64.txt")
except Exception as e:
    print(f"Failed with bike.png: {e}")
