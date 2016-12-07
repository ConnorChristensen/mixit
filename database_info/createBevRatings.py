import random

print "INSERT INTO `Bev_Likes` (`bevId`, `likes`, `dislikes`) VALUES"

for x in range(11):
    print "("+str(x+1)+", "
    print str(random.randrange(0,100))+", "
    print str(random.randrange(0,100))+"),"

print "(12, "
print str(random.randrange(0,100))+", "
print str(random.randrange(0,100))+")"
