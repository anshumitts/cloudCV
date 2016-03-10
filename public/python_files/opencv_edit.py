import sys
import cv2
import os
import glob
jobID=""
dirc = "current_work/"+jobID
def _log(str):
   f = open('/home/anshul/innomania.com/public/log/log.txt', 'a');
   f.write(str +"\r\n");
   f.close();
   pass
test = '/home/anshul/innomania.com/public/current_work/'+jobID+'*'
r = glob.glob(test)
for i in r:
   os.remove(i)

img=cv2.imread('/home/anshul/innomania.com/public/'+sys.argv[2])
run = sys.argv[1].split('-')
outstr=sys.argv[2]+"::"
image = sys.argv[2].split('/')[-1]
# img = cv2.imread("/home/anshul/innomania.com/public/"+dirc+image)
k=0
for option in run:
	values = option.split('(')
	if values[0]=='1':
		img = cv2.cvtColor( img, cv2.COLOR_RGB2GRAY )
		cv2.imwrite("/home/anshul/innomania.com/public/"+dirc+str(k)+image,img)
		_log("Converting to Grey Scale");
		outstr=outstr+dirc+str(k)+image+"::"

	elif values[0]=='2':
		img = cv2.blur(img,(int(values[1]),int(values[1])))
		cv2.imwrite("/home/anshul/innomania.com/public/"+dirc+str(k)+image,img)
		_log("Applying Gausian Blur");
		outstr=outstr+dirc+str(k)+image+"::"
		
	elif values[0]=='3':
		img = cv2.Canny( img, int(values[1]),int(values[2]))
		cv2.imwrite("/home/anshul/innomania.com/public/"+dirc+str(k)+image,img)
		_log("Applying Canny Edge");
		outstr=outstr+dirc+str(k)+image+"::"
	k=k+1
_log("Done")
print outstr