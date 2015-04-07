# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
# All Vagrant configuration is done here. The most common configuration
# options are documented and commented below. For a complete reference,
# please see the online documentation at vagrantup.com.

# Every Vagrant virtual environment requires a box to build off of.
config.vm.box = "phusion/ubuntu-14.04-amd64"

#No Autoupdate
config.vm.box_check_update = false

# Create a private network, which allows host-only access to the machine
# using a specific IP.
config.vm.network "private_network", ip: "192.168.10.10"

#set hostname
config.vm.hostname = "symfony.dev"

#Bridge
config.vm.network "public_network"

# Sync current folder
config.vm.synced_folder "./", "/var/www/app", group: "www-data", owner: "www-data", mode: 0775

#provisioning
config.vm.provision "shell", path: "./provision.sh", privileged: true

end
