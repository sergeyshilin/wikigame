f = open(r'russians.txt')
lines = f.readlines()
f.close()
try:
	for line in range(len(lines)-1):
		if lines[line] == '------------------------------\n':
			del lines[line]
except:
	pass
f = open("russians.txt", 'w')
f.writelines(lines)
f.close()
