# This is a basic VCL configuration file for varnish.  See the vcl(7)
# man page for details on VCL syntax and semantics.
# 
# Default backend definition.  Set this to point to your content
# server.
# 
backend default {
    .host = "127.0.0.1";
    .port = "8080";
}
# 
# Below is a commented-out copy of the default VCL logic.  If you
# redefine any of these subroutines, the built-in logic will be
# appended to your code.
# sub vcl_recv {
#     if (req.restarts == 0) {
# 	if (req.http.x-forwarded-for) {
# 	    set req.http.X-Forwarded-For =
# 		req.http.X-Forwarded-For + ", " + client.ip;
# 	} else {
# 	    set req.http.X-Forwarded-For = client.ip;
# 	}
#     }
#     if (req.request != "GET" &&
#       req.request != "HEAD" &&
#       req.request != "PUT" &&
#       req.request != "POST" &&
#       req.request != "TRACE" &&
#       req.request != "OPTIONS" &&
#       req.request != "DELETE") {
#         /* Non-RFC2616 or CONNECT which is weird. */
#         return (pipe);
#     }
#     if (req.request != "GET" && req.request != "HEAD") {
#         /* We only deal with GET and HEAD by default */
#         return (pass);
#     }
#     if (req.http.Authorization || req.http.Cookie) {
#         /* Not cacheable by default */
#         return (pass);
#     }
#     return (lookup);
# }
# 
# sub vcl_pipe {
#     # Note that only the first request to the backend will have
#     # X-Forwarded-For set.  If you use X-Forwarded-For and want to
#     # have it set for all requests, make sure to have:
#     # set bereq.http.connection = "close";
#     # here.  It is not set by default as it might break some broken web
#     # applications, like IIS with NTLM authentication.
#     return (pipe);
# }
# 
# sub vcl_pass {
#     return (pass);
# }
# 
# sub vcl_hash {
#     hash_data(req.url);
#     if (req.http.host) {
#         hash_data(req.http.host);
#     } else {
#         hash_data(server.ip);
#     }
#     return (hash);
# }
# 
# sub vcl_hit {
#     return (deliver);
# }
# 
# sub vcl_miss {
#     return (fetch);
# }
# 
# sub vcl_fetch {
#     if (beresp.ttl <= 0s ||
#         beresp.http.Set-Cookie ||
#         beresp.http.Vary == "*") {
# 		/*
# 		 * Mark as "Hit-For-Pass" for the next 2 minutes
# 		 */
# 		set beresp.ttl = 120 s;
# 		return (hit_for_pass);
#     }
#     return (deliver);
# }
# 
# sub vcl_deliver {
#     return (deliver);
# }
# 
# sub vcl_error {
#     set obj.http.Content-Type = "text/html; charset=utf-8";
#     set obj.http.Retry-After = "5";
#     synthetic {"
# <?xml version="1.0" encoding="utf-8"?>
# <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
#  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
# <html>
#   <head>
#     <title>"} + obj.status + " " + obj.response + {"</title>
#   </head>
#   <body>
#     <h1>Error "} + obj.status + " " + obj.response + {"</h1>
#     <p>"} + obj.response + {"</p>
#     <h3>Guru Meditation:</h3>
#     <p>XID: "} + req.xid + {"</p>
#     <hr>
#     <p>Varnish cache server</p>
#   </body>
# </html>
# "};
#     return (deliver);
# }
# 
# sub vcl_init {
# 	return (ok);
# }
# 
# sub vcl_fini {
# 	return (ok);
# }
acl purge {
	"127.0.0.1";
}

sub vcl_recv {
	# Allow purge requests
	if (req.request == "PURGE") {
        if (!client.ip ~ purge) {
            error 405 "Not allowed.";
        }
        ban("req.url ~ ^" + req.url + " && req.http.host == " + req.http.host);
        return(lookup);
    }
    
	# Add header for sending client ip to backend
	set	req.http.X-Forwarded-For = client.ip;
	
	# Normalize	content-encoding
	if (req.http.Accept-Encoding) {
        if (req.url ~ "\.(jpg|png|gif|gz|tgz|bz2|lzma|tbz)(\?.*|)$") {
            remove req.http.Accept-Encoding;
        } elsif (req.http.Accept-Encoding ~ "gzip") {
            set req.http.Accept-Encoding = "gzip";
        } elsif (req.http.Accept-Encoding ~ "deflate") {
            set	req.http.Accept-Encoding = "deflate";
        } else {
            remove req.http.Accept-Encoding;
        }
    }
    
    # Remove cookies and query string for real static files
    if (req.url ~ "^/[^?]+\.(gif|jpg|jpeg|swf|css|js|txt|flv|mp3|mp4|pdf|ico|png|gz|zip|lzma|bz2|tgz|tbz)(\?.*|)$") {
       unset req.http.cookie;
       set req.url = regsub(req.url, "\?.*$", "");
    }

    # Don't cache admin
    if (req.url ~ "((wp-(login|admin|comments-post.php|cron.php))|login)" || req.url ~ "preview=true" || req.url ~ "xmlrpc.php") {
        return (pass);
    } else {
    	if ( !(req.http.cookie ~ "wpoven-no-cache") ) {
    	    unset req.http.cookie;
    	}
	}
}

sub vcl_hit {
	# purge cached objects from memory
	if (req.request == "PURGE") {
		purge;
		error 200 "Purged";
	}
}

sub vcl_miss {
	# purge cached objects varients from memory
	if (req.request == "PURGE") {
		purge;
		error 404 "Purged varients";
	}
}

sub vcl_fetch {
	# Dont cache admin
	if (req.url ~ "(wp-(login|admin|comments-post.php|cron.php))|login" || req.url ~ "preview=true" || req.url ~ "xmlrpc.php") {
    	return (deliver);
	} else {
    	if ( beresp.ttl > 0s && !(beresp.http.set-cookie ~ "wpoven-no-cache") ) {
    	    unset beresp.http.set-cookie;
    	}
	}
}

sub vcl_deliver {
	# Remove unwanted headers
	unset resp.http.Server;
	unset resp.http.X-Powered-By;
	unset resp.http.x-backend;
	unset resp.http.Via;
	unset resp.http.X-Varnish;
}
