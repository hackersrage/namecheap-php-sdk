These classes allow the use of the namecheap.com APIs. Built using factory and strategy pattern allowing the extension of future apis.

# Intention #

Create a simple to use set of classes to integrate with the Namecheap API.

# Thoughts #

I wanted to have a "command" class that you extend in order to extend the sdk (ie new or updated api). I also wanted an easy to use config class/object. With using jQuery I enjoy the fluent interface so built the Config class using this but also with the ability to set via object notation OR pass an array of options to constructor.

# Inspiration #

I wanted to shut off my private nameservers and move to using namecheap's nameservers which required using their API. I could only find one PHP api which I didnt feel was up to the job or very extendable.