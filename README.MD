## Assumptions
Ansible, Vagrant on installed host machine.
Also hosts-updater for vagrant is installed.

``` vagrant plugin install vagrant-hostsupdater ```

## Setup
```  
$ cd /path/to/project
$ ansible-galaxy install -r build/requirements.yml
$ vagrant up
```