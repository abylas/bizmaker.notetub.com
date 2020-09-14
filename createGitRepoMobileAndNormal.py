
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


        # curl - u $1 https: // api.github.com / user / repos - d "{\"name\": \"$2\", \"description\": \"$3\"}"


        #  First read the values from a file, which contains names for all new sites.
        # Remember , we can either create both regular and mobile.blah.notetub.com sites right now, OR create another
        # script for mobile sites separatley, so that we can test things out as they go.
        #  I feel like we do both toegther right here. so let's go.



        # Steps to make this work
        #
        # 1. read names from file input.txt
        # for each name, which will be for each line, use that name,
        # create name.notetub.com, abd mobile.name.notetub.com,
        #     and upload that shit.
        #
        #
        #
        #
        #

        file = open("input.txt","r")
        for line in file:
            # print(line)
            line = line.strip("\n")
            mobileSite = "mobile." + line.rstrip() + ".notetub.com"
            regSite = line.rstrip() + ".notetub.com"

            print(mobileSite)
            user = g.get_user()
            mobileRepo = user.create_repo(mobileSite)

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

            exit_on_failure_command("git push --mirror https://github.com/abylas/" + mobileSite + ".git")
            print("Pushed and mirrored Regular site from AVA to remote ava-github successfully")

        # shutil.rmtree("ava.notetub.com.git")

        #
        # print ( "--2-dvelop-to-release-merge---------------" )
        # exit_on_failure_command( "git checkout -b release-" + release_branch_version_number +" develop")
        # print("Created a release Branch from Develop successfully")
        # # BUMP VERSION number manunally in the release log for now, next step, commit this bumped up version
        #
        # # exit_on_failure_command("git commit -a -m \"Bumped version number to "  + release_branch_version_number + " \" ")
        # # print("Bumped version number successfully")
        #
        # print("-------Finishing the release branch by merging with mster and tagging-----------")
        # exit_on_failure_command("git checkout master")
        # print("Checked out master branch successfully")
        # exit_on_failure_command("git merge --no-ff release-" + release_branch_version_number)
        # print("MERGED RELEASE branch with MASTER successfully")
        # exit_on_failure_command("git tag -a " + release_branch_version_number)
        # print("Tagged successfully")
        #
        # #
        # # exit_on_failure_command("git push --all origin")
        # # print("Pushed all bracnhes successfully")
        # exit_on_failure_command("git push --all ava-github")
        # print("Pushed all branches successfully")
        # exit_on_failure_command("git push ava-github --tags")
        # print("Pushed all Tags successfully")


        # for module in modules:
        #     os.chdir(FULL_DIR)
        #     moduledetails = module[0].split("/")
        #     url = "https://github.com/"+ moduledetails[0] +"/"+ moduledetails[1] + ".git"
        #     exit_on_failure_command("git clone " + url)
        #     os.chdir(moduledetails[1])
        #     run_command("pwd")


try:
    sync_master()
except SystemExit as e:
    sys.exit(-1)










