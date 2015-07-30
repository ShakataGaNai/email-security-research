# email-security-research
Are you curious about SPF and DMARC record usage? I was too. So I wrote this small script to run through and look for the SPF and DMARC records for given domains.  A large dataset was needed, so I decided to use the [Quantcast top million sites](https://www.quantcast.com/top-sites).  Granted some of the domain names are hidden, and some are not top level sites, so we don't get a million rows of data back.  However we do get more than enough.

## How to use it
* run `$ ./getdata.sh` to fetch and unzip the data
* run `$ php check-domain-dns.php` to crawl the domains
* Look in `/results/` for the resulting CSV file

By default, the PHP script only checks the "Top 50" domains. To do the whole shebang, un-comment the `#$infile = "Quantcast-Top-Million.txt";` line.  Speed of results will depend on your internet connection and DNS resolver.  My initial test took 8 hours.

## Why no DKIM?
DMARC records are always located at `_dmarc.domain.tld` per RFC.  SPF records are always stored in a root level TXT record.  However DKIM records can be stored under any name, as long as it matches what the sending mail server uses.  Since we could only guess, our data there would be wildly inaccurate at best, and completely blank at worst.

## License
* Code is licnsed under the MIT license.
* Quantcast Top Million U.S. Web Sites, Copyright 2015 Quantcast Corporation. Data is subject to terms of use described at https://www.quantcast.com/learning-center/quantcast-terms/website-terms-of-use/
