# -*- mode: ruby -*-
# vi: set ft=ruby :

VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "hashicorp/precise64"
  config.vm.network "private_network", ip: "192.168.233.25"
  config.vm.provision "shell", path: "vagrant-config/provision.sh"
  config.vm.provision "shell", run: "always", path: "vagrant-config/startup.sh"
end
