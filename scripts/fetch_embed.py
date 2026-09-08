import urllib.request
import re
import os

headers = {
    'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
    'Accept-Language': 'es-ES,es;q=0.9,en;q=0.8'
}

codes = [
    (1, 'DOJ4SttEviA'),
    (2, 'DOJ4St6Eux3'),
    (3, 'DOJ4SuBkhAc'),
    (7, 'DOKNBZgkiJO')
]

for idx, code in codes:
    url = f'https://www.instagram.com/p/{code}/embed/captioned/'
    req = urllib.request.Request(url, headers=headers)
    try:
        with urllib.request.urlopen(req) as resp:
            html = resp.read().decode('utf-8', errors='ignore')
            
            # Look for EmbeddedMediaImage or cdninstagram
            imgs = re.findall(r'class="EmbeddedMediaImage"[^>]*src="([^"]+)"', html)
            if not imgs:
                imgs = re.findall(r'https://[^"\'<>\s]+cdninstagram[^"\'<>\s]+', html)
            
            clean = []
            for img in imgs:
                img = img.replace('&amp;', '&')
                if 'scontent' in img:
                    clean.append(img)
            
            print(f"Slide {idx} ({code}): Found {len(clean)} images")
            if clean:
                target_url = clean[0]
                save_path = f"public/images/proceso/slide_{idx}.jpg"
                img_req = urllib.request.Request(target_url, headers=headers)
                with urllib.request.urlopen(img_req) as img_resp, open(save_path, 'wb') as out:
                    out.write(img_resp.read())
                print(f"-> Saved: {save_path} ({os.path.getsize(save_path)} bytes)")
    except Exception as e:
        print(f"Error fetching {code}: {e}")
