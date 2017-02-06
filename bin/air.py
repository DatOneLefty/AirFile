import os
import sys
try:
	sys.argv[1]
except:
	os.system("google-chrome --app=http://localhost:25500/index.php?FS=" + os.environ['HOME']);
else:
	os.system("google-chrome --app=http://localhost:25500/index.php?FS=" + sys.argv[1]);	

