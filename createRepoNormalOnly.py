
import os
import shutil
import sys
from github import Github

#  HOW TO RUN this script - > type command below on command line or powershell while in same dir with git n local.py
#        "C:\Program Files (x86)\Microsoft Visual Studio\Shared\Anaconda3_64\python.exe" local.py

# MAKE thre four of thse scripts, one for one go from
# 1. onegofeaturetoprod
# 2. feature to release
# 3.  release to prod
# 4. release to prod plus tag


# main
# get the feature branch name
# curr_branch_name = sys.argv[1]
# release_branch_version_number = sys.argv[2]
# param_3= sys.argv[3]

FULL_DIR = os.getcwd()
os.chdir(FULL_DIR)
print("Changed directory")

def run_command(cmd):
    # print("Executing: ") + cmd
    print("Running following command")
    print(cmd)
    return os.system(cmd)

def exit_on_failure_command(cmd):
    retval = run_command(cmd)
    print("Ran command")
    if retval !=0:
        print("Command: " + cmd + " failed with value: "),  retval
        sys.exit(retval)

def sync_master():


        os.chdir(FULL_DIR)
        g = Github("abylas", "gitme41")

        url = "https://github.com/abylas/GitWorkflow.git"


        # Steps to make this work
        #
        # 1. read names from file input.txt
        # for each name, which will be for each line, use that name,
        # create name.notetub.com, abd mobile.name.notetub.com,
        #     and upload that shit.
        #
        #

        file = open("input.txt","r")
        for line in file:
            # print(line)
            line = line.strip("\n")
            regSite = line.rstrip() + ".notetub.com"

            print(regSite)
            user = g.get_user()
            regRepo= user.create_repo(regSite)

            exit_on_failure_command("git clone --bare https://github.com/abylas/ava.notetub.com.git")
            print("Cloned AVA successfully")
            # exit_on_failure_command("cd ava.notetub.com.git")
            os.chdir("ava.notetub.com.git")

            print("Changed directory into AVA successfully")
            exit_on_failure_command("git push --mirror https://github.com/abylas/" + regSite + ".git")
            print("Pushed and mirrored Regular site from AVA to remote ava-github successfully")

try:
    sync_master()
except SystemExit as e:
    sys.exit(-1)










