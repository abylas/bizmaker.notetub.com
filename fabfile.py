from fabric import Connection as connection, task


import os
import shutil
import sys
from github import Github

@task
def clonendeploy(ctx):
    with connection(host="notetub.com", 
					user="notetubc", 
					port="7822", 
					connect_kwargs={"key_filename": "C:\\a2hosting\\publickey\\id_rsa",},
					) as c:
							file = open("input.txt","r")
							for line in file:
								# print(line)
								line = line.strip("\n")
								regSite = line.rstrip() + ".notetub.com.git"

								print(regSite)

								gitCloneCmd = 'git clone https://abylas:gitme41@github.com/abylas/' + regSite
								print(gitCloneCmd)	
								c.run(gitCloneCmd)
								print("Successfully ran git clone for above")