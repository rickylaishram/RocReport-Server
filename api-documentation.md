## API Documentation

Required parameters are in bold

All responses are in JSON.

#### Register

__POST /api/auth/register/__

Parameter 		| Description
----------------|---------------------
__id__			| The client id
__email__		| Email of the user
__password__	| Password of the user
__name__ 		| The username


#### Login

__POST /api/auth/login/__

Parameter		| Description
----------------|------------------
__id__			| The client id
__email__ 		| The user email
__password__ 	| The user password


#### Add Report

__Requires Authentication__

__POST /api/report/add/__

Parameter				| Description
------------------------|------------------
__id__					| The client id
__token__ 				| The authentication token
formatted_address	 	| 
country					| 
admin_level_1			|
admin_level_2			|
sublocality				|
__latitude__			|
__longitude__			|
__category__			| The report category
__description__			| Report description
__picture__				| Link to photo
__novote__				| If set to false, server will return nearby reports instead of adding new one


#### Fetch Reports By Me

__Requires Authentication__

__POST /api/report/fetch_mine/__

Parameter				| Description
------------------------|------------------
__id__					| The client id
__token__ 				| The authentication token
orderby					| Order by score or new. Defaults to score.


#### Fetch Reports In Area

__POST /api/report/fetch/__

Parameter				| Description
------------------------|------------------
id						| The client id
token 					| The authentication token
orderby					| Order by score or new. Defaults to score
__type__				| Area type - admin_level_1, admin_leven_2 or sublocality
__name__				| Area name
offset					| Defaults to 0
limit					| Defaults to 0. Maximum is 100.


#### Add vote

__Requires Authentication__

__POST /api/report/vote/__

Parameter				| Description
------------------------|------------------
__id__					| The client id
__token__ 				| The authentication token
__report__				| The report id


#### Add to watch list

__Requires Authentication__

__POST /api/report/watch/__

Parameter				| Description
------------------------|------------------
__id__					| The client id
__token__ 				| The authentication token
__report__				| The report id


#### Upload Image

__Requires Authentication__

__POST /api/image/add/__

Parameter				| Description
------------------------|------------------
__id__					| The client id
__token__ 				| The authentication token
__image__				| The image. Max size 1600x1600 and 500kb

