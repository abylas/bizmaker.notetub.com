#!/bin/bash
#Usage: .\local

# Command below in comments is for my windows machine. for creating a Windows batch file.
#"C:\Program Files (x86)\Microsoft Visual Studio\Shared\Anaconda3_64\python.exe" local.py

echo "=========*****STARTING SCRIPT*****=============="
echo "PERSONAL only REPOS CLONE AND DEPLOY TOOL"

echo "Deleting preexisting ava.notetub.com.git"
rm -Rf ava.notetub.com.git

echo "====="

echo "Processing Git commands, by calling on python script createRepoNormalOnly.py"
python createRepoNormalOnly.py

echo "==========="

fab deploy $1 $2 $3


echo "===******FINISHED SCRIPT******====="
