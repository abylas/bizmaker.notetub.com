::Usage: fab list_files current-feature-branch-name tag-version-number TAG-DESCRIPTION New-feature-branch-name

:: Example : .\local.bat f91401 v-9.14.0.1 "Tag for feature branch version 9.14.0.1" f91501 

:: feature-name - name of this feature branch - in format - "fxxxxx" - example, f91301, means feature branch 9.13.0.1
:: tag-version-number - in format  "v-9.13.0.1" , for the tags
:: tag-description - in quotes. probably, simpl,e description for the tags


:: Command below in comments is for my windows machine. for creating a Windows batch file.
::"C:\Program Files (x86)\Microsoft Visual Studio\Shared\Anaconda3_64\python.exe" local.py $1 $2 $3



@ECHO OFF
:: This batch file helps merge your current feature breanch to develop, then master, then reease, and then tags it. you still need to pull wherever you need it. and switch back to a new branch. and upgrade your version number

TITLE PERSONAL REPOS CLONE AND DEPLOY TOOL - Clone repo and deploy to production


ECHO ============================
ECHO PERSONAL REPOS CLONE AND DEPLOY TOOL
ECHO Usage: .\clone.bat
::ECHO Example : local.bat f91401 v-9.14.0.1 "Tag for feature branch version 9.14.0.1 f91501" 
ECHO ============================


ECHO Please wait... Working on git commands.

ECHO ============================
ECHO Processing Git commands, by calling on python script createRepoNormalOnly.py
ECHO ============================

"C:\Program Files (x86)\Microsoft Visual Studio\Shared\Anaconda3_64\python.exe" createRepoNormalOnly.py
ECHO Created repos on github

ECHO ============================
ECHO Now, Using fab to ssh and clone the git repos on production
ECHO ============================

fab clonendeploy
ECHO used fab to git clone onto production
:: fab list_files -i C:\a2hosting\publickey\id_rsa.ppk -H notetubc@notetub.com:7822
:: "C:\Program Files (x86)\Microsoft Visual Studio\Shared\Anaconda3_64\python.exe" local.py %1 %2 %3 %4
PAUSE