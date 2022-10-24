resource "aws_key_pair" "victordev1_pk" {
    key_name = "victordev1_pk"
    public_key = file("./.pk/victordev1_pk.pub")
}

data "aws_ami" "ubuntu" {
    most_recent = "true"

    filter {
        name = "name"
        values = ["ubuntu/images/hvm-ssd/ubuntu-focal-20.04-amd64-server-*"]
    }

    filter {
        name = "virtualization-type"
        values = ["hvm"]
    }

    owners = ["099720109477"]
}

resource "aws_instance" "victordev1_web" {
    count = var.SETTINGS.web_app.count
    ami = data.aws_ami.ubuntu.id
    instance_type = var.SETTINGS.web_app.instance_type
    subnet_id = aws_subnet.victordev1_public_subnet[count.index].id
    key_name = aws_key_pair.victordev1_pk.key_name
    vpc_security_group_ids = [aws_security_group.victordev1_web_sg.id]

    tags = {

        Name = "victordev1_web_${count.index}"
        Project = "victordev1"
    }
}

resource "aws_eip" "victordev1_web_eip" {
    count = var.SETTINGS.web_app.count
    instance = aws_instance.victordev1_web[count.index].id
    vpc = true

    tags = {
        Name = "victordev1_web_eip_${count.index}"
        Project = "victordev1"
    }

    connection {
        host    = self.public_ip
        type    = "ssh"
        user    = "ubuntu"
        private_key = file("./.pk/victordev1_pk.pem")
    }

    provisioner "remote-exec" {
        inline = ["echo 'built server!'"]
    }

    provisioner "local-exec"{
        command = "echo ${aws_eip.victordev1_web_eip[count.index].public_dns} > ansible/hosts"
    }
}
