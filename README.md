PHPAppConfig
============

AppConfig for php -- This version supports multiple database connection strings, a public folder url in case you are required to append it to some local urls, a home url for the web root, navigation, and a debug flag. XML Web Application Configuration for PHP

### Usage
- Load your configuration file:
`$config = AppConfig::getInstance('./appconfig.xml');`
- Once you load the file once on your page you may access it without the path variable:
`$config = AppConfig::getInstance();`
- To grab __all__ the nodes of your xml configuration file:
`AppConfig::getInstance()->getEnv();`
- Or use xpath:
`AppConfig::getInstance()->getEnv('//db/host');`

### Debug Flag
- You must have a debug flag at the root of each environment definition.
- To access your debug flag (return type: *boolean*):
`AppConfig::getInstance()->getDebug()`

## Sample AppConfig.xml (should be stored in the root folder -- will make configurable very soon.)
```xml
<?xml version="1.0" encoding="UTF-8" ?> 
<config>
  <mode>development</mode>
	<development>
		<home>/project/localfolder</home>
		<db>
			<host>mysql:host=localhost;dbname=testdb</host>
			<user>root</user>
			<pass>null</pass>
		</db>
		<web>
			<nav>
				<user>
					<link name='Fav' prepend='home' path="/favs" />
					<link name='Profile' prepend='home' path="/profile" />
				</user>
				<admin>
			        <link name='Annoucements' prepend='home' path="/annoucements" />
			        <link name='Settings' prepend='home' path="/questions" />
			        <link name='Users' prepend='home' path="/users" />
				</admin>
				<all>
			        <link name='Home' prepend='home' path="/" />
			        <link name='About' prepend='home' path="/about" />
			        <link name='Search' prepend='home' path="/annoucements" />
				</all>
			</nav>
		</web>
		<debug>true</debug>
	</development>
	<staging>
		<home>/project/dev-cris</home>
		<db>
			<host>mysql:host=dbhost.com;dbname=sandboxdb</host>
			<user>sandbox</user>
			<pass>testbox</pass>
		</db>
		<web>
			<nav>
				<user>
					<link name='Fav' prepend='home' path="/favs" />
					<link name='Profile' prepend='home' path="/profile" />
				</user>
				<admin>
			        <link name='Annoucements' prepend='home' path="/annoucements" />
			        <link name='Settings' prepend='home' path="/users" />
				</admin>
				<all>
			        <link name='Home' prepend='home' path="/" />
			        <link name='About' prepend='home' path="/about" />
			        <link name='Search' prepend='home' path="/annoucements" />
				</all>
			</nav>
		</web>
		<publicfolder>/staging/sandbox/</publicfolder>
		<debug>true</debug>
	</staging>
	<production>
		<home>/project/</home>
		<db>
			<host>mysql:host=dbhost.com;dbname=proddb</host>
			<user>produser</user>
			<pass>djfs34231!examp!e</pass>
		</db>
		<debug>false</debug>
	</production>
</config>
```
## To Do
- Allow `nav` tag, and db tag to have a `src` attribute with the file location of the for the inner nodes.
- Make env cast types to string to remove that burden from the user, current env has XML nodes which can be casted to get the string value.
