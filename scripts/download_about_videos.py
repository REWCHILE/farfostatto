import subprocess
import os

urls = [
    ("about_1", "https://www.instagram.com/reel/DQ5WD0XD0Fl/"),
    ("about_2", "https://www.instagram.com/reel/DXxpPD1v37T/"),
    ("about_3", "https://www.instagram.com/reel/DNWj1ycvoJF/"),
    ("about_4", "https://www.instagram.com/reel/DMu8O6xuLgg/"),
    ("about_5", "https://www.instagram.com/reel/DMf6SBsxG1_/"),
]

os.makedirs("public/videos/about", exist_ok=True)

for name, url in urls:
    out_tmpl = f"public/videos/about/{name}.%(ext)s"
    print(f"=== Downloading {name} ({url}) ===")
    cmd = ["yt-dlp", "-o", out_tmpl, "--write-thumbnail", url]
    res = subprocess.run(cmd, capture_output=True, text=True)
    if res.returncode == 0:
        print(f"OK: {name}")
    else:
        print(f"ERR {name}:", res.stderr[:300])
