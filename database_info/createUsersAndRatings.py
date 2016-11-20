import random


def printUserValues():
    usernames = []
    for x in range(16):
        usernames.append(str(words[random.randrange(0, len(words))]))

    print "INSERT INTO `Users` (`username`, `password`, `email`) VALUES ";
    for x in range(15):
        password = ""
        for y in range(20):
            password += chr(random.randrange(97,122));
        
        print "('"+usernames[x]+"', '"+str(password)+"', '"+str(words[random.randrange(0, len(words))])+"@gmail.com'),"


    password = ""
    for y in range(20):
        password += chr(random.randrange(97,122));
    print "('"+str(words[random.randrange(0, len(words))])+"', '"+str(password)+"', '"+str(words[random.randrange(0, len(words))])+"@gmail.com');"


def printUserRatings():
    print "INSERT INTO `User_Ratings` (`username`, `bevId`, `rating`) VALUES ";
    for x in range(20):
        print "('"+usernames[random.randrange(0,15)]+"', "+str(random.randrange(1,12))+", "+str(random.randrange(0,1))+"), "

    print "('"+usernames[3]+"', "+str(random.randrange(1,12))+", "+str(random.randrange(0,1))+"); "

word_file = "/usr/share/dict/words"
words = open(word_file).read().splitlines()


printUserValues()
                     

