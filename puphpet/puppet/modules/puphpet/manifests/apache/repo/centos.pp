# Installs Apache 2.4 for CentOS 6
define puphpet::apache::repo::centos {
  $httpd_url               = 'http://repo.puphpet.com/centos/httpd24/httpd-2.4.10-RPM-full.x86_64.tgz'
  $httpd_download_location = '/.puphpet-stuff/httpd-2.4.10-RPM-full.x86_64.tgz'
  $httpd_tar               = "tar xzvf '${httpd_download_location}'"
  $extract_location        = '/.puphpet-stuff/httpd-2.4.10-RPM-full.x86_64'

  $download_httd_cmd = "wget --quiet --tries=5 \
    --connect-timeout=10 -O '${httpd_download_location}' \
    '${httpd_url}'"

  exec { 'download httpd-2.4.10':
    creates => $httpd_download_location,
    command => $download_httd_cmd,
    timeout => 3600,
    path    => '/usr/bin',
  } ->
  exec { 'untar httpd-2.4.10':
    creates => $extract_location,
    command => $httpd_tar,
    cwd     => '/.puphpet-stuff',
    path    => '/bin',
  } ->
  exec { 'install httpd-2.4.10':
    creates => '/etc/httpd',
    command => 'yum -y localinstall * --skip-broken',
    cwd     => $extract_location,
    path    => '/usr/bin',
  }

  exec { 'rm /etc/httpd/conf.d/systemd.load':
    path    => ['/usr/bin', '/usr/sbin', '/bin'],
    onlyif  => 'test -f /etc/httpd/conf.d/systemd.load',
    require => Class['apache'],
    notify  => Service['httpd'],
  }
}
