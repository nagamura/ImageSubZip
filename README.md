# ImageSubZip
Create zip files under 50MB

# Set up
Rename directory

data.base -> data

zip.base -> zip

Set permisson to 0777

$chmod 0777 data zip

Set image data to zip in data directory

# File structure
<pre>
index.php
├── data
└── zip
</pre>


# Creating zip files

Execute index.php

$php -f index.php

Zip files will be created in zip directory