# Dissertation-Kubernetes-lab-solution
A virtual learning environment that provides containerized lab infrastructure on Kubernetes to allow students to dynamically request their own single or multi node lab environments.


## Overview
Running on a local minikube cluster (Google Kubernetes Engine was also explored and can be used) a LAMP stack is deployed allowing for a student portal.
The apache service authenticates with the kubernetes API server through the kube proxy or alternativly using the apache servers service accounts auth token and ca.crt.
Once authenticated the apache service can make curl requests to the kubernetes API allowing kubernetes objects to be created through the student portal.


<img src="https://github.com/HarryOverton118/Dissertation-Kubernetes-lab-solution/blob/master/Screenshots/solution_diagram.PNG?raw=true" width="75%" height="75%">

Each user gets their own kubernets namespace for their lab infrastructure so they are isolated from other students labs or other components of the solution.
group labs can be created with multiple lab deployments in a single namespace allwoing for students to work collaboratively.
Using a suitable image of a lab environemnt with shell in a box configured, labs deployed through the student portal can also be accessed via the an emulated terminal displayed on the portal:

<img src="https://github.com/HarryOverton118/Dissertation-Kubernetes-lab-solution/blob/master/Screenshots/group_lab.gif?raw=true" width="100%" height="100%" class="center">


## Setup

## Recommendations
### GNS3 Intigration
The labs just consisted of host devices such as ubuntu hosts which could communicate within their Kubernetes namespaces. 
To provide an all-in-one lab environment where students could configure hosts as well as network topologies, with routing and switching GNS3 could be used. 
Ultimately packet tracer was used to simulate network labs however, GNS3 could allow for integration with the actual containerized devices deployed in the Kubernetes labs as it allows for real devices to be connected to the simulated network topology.

### Lab Images
The lab solution allows for new docker images to be sourced or created to add new devices with new tools to the available lab environments.
To improve the current implementation of the lab solution more images should be created.
These images would require a shell in a box configured on them so they can be accessed from the web portal.
Spreitzer's (2018) docker shell in a box docker file could be used for reference on how this is done.
By creating shell in  a box images for other operating systems the range of the labs available could be greatly increased.
One example that was initially considered was doing this with a kali Linux operating system, used for digital forensics and penetration testing.
This would expand the labs making them also viable for cybersecurity units, not just networking.
