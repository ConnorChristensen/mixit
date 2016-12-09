=pod
 key in array
 [0] name
 [1] type
 [2] glass
 [3] instructions
 [4] number of ingredients
 [5-end] ingredients
=cut

use strict;
use warnings;

sub insertStatements {
    my $filePath = "http://web.engr.oregonstate.edu/~chriconn/mixit/database_info/";
    #bring in passed variables
    my $x = $_[0];
    my $lineCount = $_[1];
    my $graves = $_[2];
    my @splitLine = @{$_[3]};
    my $textFileName = $_[4];
    
    if ($graves) {
        print outputFile "\n\t(";
        print outputFile "`$splitLine[0]`, ";
        print outputFile "`$splitLine[1]`, ";
        print outputFile "`$splitLine[2]`, ";
        print outputFile "`images/drinks/$textFileName.jpg`, ";
        print outputFile "`description/$textFileName.txt`, ";
        print outputFile "`instructions/$textFileName.txt`, ";
        print outputFile "`ingredients/$textFileName.txt`";
        if ($x >= $lineCount) {
            print outputFile ");";
        }
        else {
            print outputFile "),";
        }
    } else {
        print outputFile "\n\t(";
        print outputFile "'$splitLine[0]', ";
        print outputFile "'$splitLine[1]', ";
        print outputFile "'$splitLine[2]', ";
        print outputFile "'images/drinks/$textFileName.jpg', ";
        print outputFile "'description/$textFileName.txt', ";
        print outputFile "'instructions/$textFileName.txt', ";
        print outputFile "'ingredients/$textFileName.txt'";
        if ($x >= $lineCount) {
            print outputFile ")";
        }
        else {
            print outputFile "),";
        }
    }
}


sub main() {
    #do you want gravesin the sql output
    my $graves = 0;

    my $databaseName = "Bevs";
    
    #open the file to read in from
    open(myFile, "<databaseInfo.tsv");

    #read in info from file
    my @lines = <myFile>;

    #close the file that we read in from
    close(myFile);
    
    #open the file to write out to
    open(outputFile, ">SQLInsert.txt");
    
    
    #print the header for the SQL statement
    print outputFile "INSERT INTO $databaseName (`bevName`, `type`, `glass`, `photo`, `description`, `instructions`, `ingredientList`)\nVALUES ";
    
    #if the instructions folder doesn't already exits create it
    if (! -e "instructions") {
        mkdir("instructions");
    }
    if (! -e "ingredients"){
        mkdir("ingredients");
    }
    if (! -e "description") {
        mkdir("description");
    }
    
    #create the array that will store the split info from the input line
    my @splitLine;
    my $line;
    #for loop from the 1st line to the last line in the array
    #starts at the first line to skip the header titles
    for (my $x = 1; $x < scalar @lines; $x++) {
        
        #store the line in the array in a line scalar
        $line = "$lines[$x]";
        
        #remove the new lines at the end of the line
        chomp $line;
        
        #if the line is not empty
        if ($line !~ m/^\s*$/) {
            
            #split the line by pipes
            @splitLine = split /\t/, $line;
            
            #create ingredients file name with replaced spaces for underscores
            my $textFileName = $splitLine[0];
            $textFileName =~ s/\s/_/g;

            #creates the SQL insert file
            insertStatements($x, (scalar @lines)-1, $graves, \@splitLine, $textFileName);

            #create description file
            open(descriptionOutput, ">", "description/$textFileName.txt") or die "Couldn't open: $!";
            
            if ($splitLine[4] =~ m/^\s*$/) {
                print descriptionOutput "No description available";
            }
            else {
                print descriptionOutput "$splitLine[4]";
            }
            
            #create ingredients file
            open(ingredientsOutput, ">", "ingredients/$textFileName.txt") or die "Couldn't open: $!";
            
            #count of ingredients are found at index 5 and continue from there
            for (my $t = 6; $t < ($splitLine[5]*2)+6; $t+= 2) {
                print ingredientsOutput "$splitLine[$t] $splitLine[$t+1]\n";
            }
            
            #count of garnishes is at 31 if it is a digit
            if ((scalar @splitLine >= 31) and ($splitLine[31] =~ /\d/)) {
                #for the ammount of that digit, loop through and print results
                for (my $t = 32; $t < ($splitLine[31]*2)+32; $t+= 2) {
                    print ingredientsOutput "$splitLine[$t] $splitLine[$t+1]\n";
                }
            }
            close(ingredientsOutput);

            #create instructions file
            open(ingredientsOutput, ">", "instructions/$textFileName.txt") or die "Couldn't open: $!";
            print ingredientsOutput "$splitLine[3]\n";
            close(ingredientsOutput);
            
        }
    }
    
    print outputFile ";\n\n";
    
    #for loop from the 1st line to the last line in the array
    for (my $x = 1; $x < scalar @lines; $x++) {
        
        #store the line in the array in a line scalar
        $line = "$lines[$x]";
        
        #remove the new lines at the end of the line
        chomp $line;
        
        #if the line is not empty
        if ($line !~ m/^\s*$/) {
            
            #split the line by pipes
            @splitLine = split /\t/, $line;
            
            #create ingredients file name with replaced spaces for underscores
            my $textFileName = $splitLine[0];
            
            print outputFile "INSERT INTO Ingredients (`ingredName`, `bevName`)\nVALUES ";
            
            for (my $y = 6; $y < ($splitLine[5]*2)+6; $y+= 2) {
                #convert to lowercase
                $splitLine[$y+1] =~ tr/A-Z/a-z/;
                #if it is the last thing to print, don't include a comma at the end
                if ($y == ($splitLine[5]*2)+4) {
                    #print the ingrediant and the name of the drink
                    print outputFile "('", $splitLine[$y+1], "', '", $textFileName, "')";
                } else {
                    print outputFile "('", $splitLine[$y+1], "', '", $textFileName, "'), ";
                }
            }
            print outputFile ";\n\n";
        }
    }
    
    print "SQL insert statement created\n";
    close(outputFile);
}

main();
