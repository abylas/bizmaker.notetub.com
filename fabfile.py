from fabric import Connection as connection, task

@task
def deploy(ctx):
    with connection(host="notetub.com", 
					user="notetubc", 
					port="7822", 
					connect_kwargs={
        "key_filename": "C:\\a2hosting\\publickey\\id_rsa",
    },
) as c:
         c.run('ls -l')