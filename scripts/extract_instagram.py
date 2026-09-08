import re
import json
import urllib.request
import os

content_path = r"C:\Users\abak_\.gemini\antigravity-ide\brain\0104eab4-c0e4-4e2d-a2e6-5bdd2dbaca0f\.system_generated\steps\331\content.md"

with open(content_path, "r", encoding="utf-8", errors="ignore") as f:
    text = f.read()

# Look for image URLs or carousel data
img_matches = re.findall(r'https://[^"\'<>\s]+cdninstagram\.com/[^"\'<>\s]+', text)
clean_urls = []
seen = set()

for u in img_matches:
    u = u.replace("&amp;", "&").replace("\\u0026", "&")
    # Clean trailing characters
    u = re.sub(r'["\';].*$', '', u)
    if "scontent" in u and u not in seen:
        seen.add(u)
        clean_urls.append(u)

print(f"Total candidate images found: {len(clean_urls)}")
for i, u in enumerate(clean_urls[:15]):
    print(f"[{i+1}] {u}\n")

# Check if there are captions, alt texts or display_resources
alts = re.findall(r'"accessibility_caption":"([^"]+)"', text)
print(f"Accessibility captions found: {len(alts)}")
for i, a in enumerate(alts[:10]):
    print(f"Caption {i+1}: {a}")

