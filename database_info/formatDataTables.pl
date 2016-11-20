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
        print outputFile "`./description/$textFileName.txt`, ";
        print outputFile "`./instructions/$textFileName.txt`, ";
        print outputFile "`./ingredients/$textFileName.txt`";
        if ($x >= $lineCount) {
            print outputFile ")";
        }
        else {
            print outputFile "),";
        }
    } else {
        print outputFile "\n\t(";
        print outputFile "'$splitLine[0]', ";
        print outputFile "'$splitLine[1]', ";
        print outputFile "'$splitLine[2]', ";
        print outputFile "'./description/$textFileName.txt', ";
        print outputFile "'./instructions/$textFileName.txt', ";
        print outputFile "'./ingredients/$textFileName.txt'";
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
    open(myFile, "<databaseInfo.txt");

    #read in info from file
    my @lines = <myFile>;

    #close the file that we read in from
    close(myFile);
    
    #open the file to write out to
    open(outputFile, ">SQLInsert.txt");
    
    
    #print the header for the SQL statement
    print outputFile "INSERT INTO $databaseName (`name`, `type`, `glass`, `description`, `instructions`, `ingredientList`)\nVALUES ";
    
    #if the instructions folder doesn't already exits create it
    if (! -e "instructions") {
        mkdir("instructions");
    }
    if (! -e "ingredients"){
        mkdir("ingredients");
    }
    
    #create the array that will store the split info from the input line
    my @splitLine;
    my $line;
    #for loop from the 0th line to the last line in the array
    for (my $x = 0; $x < scalar @lines; $x++) {
        
        #store the line in the array in a line scalar
        $line = "$lines[$x]";
        
        #remove the new lines at the end of the line
        chomp $line;
        
        #if the line is not empty
        if ($line !~ m/^\s*$/) {
            
            #split the line by pipes
            @splitLine = split /\|/, $line;
            
            #create ingredients file name with replaced spaces for underscores
            my $textFileName = $splitLine[0];
            $textFileName =~ s/\s/_/g;
            
            #creates the SQL insert file
            insertStatements($x, (scalar @lines)-1, $graves, \@splitLine, $textFileName);
            
            #create ingredients file
            open(ingredientsOutput, ">", "ingredients/$textFileName.txt") or die "Couldn't open: $!";
            for (my $y = 5; $y < ($splitLine[4]*2)+5; $y+= 2) {
                print ingredientsOutput "$splitLine[$y] $splitLine[$y+1]\n";
            }
            close(ingredientsOutput);
            
            #create instructions file
            open(ingredientsOutput, ">", "instructions/$textFileName.txt") or die "Couldn't open: $!";
            print ingredientsOutput "$splitLine[3]\n";
            close(ingredientsOutput);
            
        }
    }
    print outputFile ";\n\n";
    
    #for loop from the 0th line to the last line in the array
    for (my $x = 0; $x < scalar @lines; $x++) {
        
        #store the line in the array in a line scalar
        $line = "$lines[$x]";
        
        #remove the new lines at the end of the line
        chomp $line;
        
        #if the line is not empty
        if ($line !~ m/^\s*$/) {
            
            #split the line by pipes
            @splitLine = split /\|/, $line;
            
            #create ingredients file name with replaced spaces for underscores
            my $textFileName = $splitLine[0];
            $textFileName =~ s/\s/_/g;
            
            print outputFile "INSERT INTO Ingredients (`name`, `bevId`) \nVALUES ";
            
            for (my $y = 0; $y < $splitLine[4]*2; $y+=2) {
                if ($y == ($splitLine[4]*2)-2) {
                    my $temp = $splitLine[$y+6];
                    $temp =~ s/\r//g;
                    print outputFile "('", $temp, "', ", $x+1, ")";
                } else {
                    print outputFile "('", $splitLine[$y+6], "', ", $x+1, "), ";
                }
            }
            print outputFile ";\n\n";
        }
    }
    
    print "SQL insert statement created\n";
    close(outputFile);
}

main();
