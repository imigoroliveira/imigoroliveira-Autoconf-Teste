#Code bellow will only works in Linux and MacOs Systems, for use in Windows just write commands listed in 4, 6 and 8 lines!#

build:
	docker-compose build --no-cache --force-rm
stop:
	docker-compose stop
up:
	docker-compose up -d

