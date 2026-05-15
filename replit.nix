{ pkgs }: {
	deps = [
		pkgs.php82
		pkgs.php82Packages.composer
    pkgs.php82Extensions.gd
    pkgs.php82Extensions.mbstring
    pkgs.php82Extensions.xml
    pkgs.php82Extensions.curl
    pkgs.php82Extensions.zip
    pkgs.php82Extensions.pdo
    pkgs.php82Extensions.pdo_sqlite
    pkgs.php82Extensions.sqlite3
    pkgs.sqlite
	];
}
