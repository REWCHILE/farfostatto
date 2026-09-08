import subprocess
import json
import urllib.request
import os

os.makedirs('public/images/proceso', exist_ok=True)

# Run yt-dlp to dump all JSON playlist info
cmd = ['yt-dlp', '-J', 'https://www.instagram.com/p/DOKNBZgkiJO/']
p = subprocess.run(cmd, capture_output=True, text=True)

if p.returncode != 0:
    print("Error running yt-dlp:", p.stderr[:300])

data = json.loads(p.stdout)
entries = data.get('entries', [])
print(f"Number of playlist entries: {len(entries)}")

headers = {
    'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
}

for idx, entry in enumerate(entries):
    if entry is None:
        print(f"\nSlide {idx+1}: None (image-only entry)")
        continue
    title = entry.get('title') or entry.get('fulltitle') or f"Slide {idx+1}"
    thumbnail = entry.get('thumbnail')
    print(f"\nSlide {idx+1} [ID: {entry.get('id')}]:")
    print(f"Title: {title}")
    
    thumbs = entry.get('thumbnails', [])
    print(f"Thumbnails available: {len(thumbs)}")
    best_thumb = thumbs[-1]['url'] if thumbs else thumbnail
    
    if best_thumb:
        save_path = f"public/images/proceso/slide_{idx+1}.jpg"
        try:
            req = urllib.request.Request(best_thumb, headers=headers)
            with urllib.request.urlopen(req) as resp, open(save_path, 'wb') as out:
                out.write(resp.read())
            print(f"Saved: {save_path} ({os.path.getsize(save_path)} bytes)")
        except Exception as e:
            print(f"Failed to download {save_path}: {e}")

