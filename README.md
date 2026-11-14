# RangeOps

Documentation and automation from building out a Proxmox-based cyber range: VM templates, scripted deployment of student lab environments, and intentionally vulnerable red team scenarios to practice against.

The repo has two parts:

## VM Creations

Step-by-step builds for the base images used across the range, plus automation for deploying them at scale.

| File | Description |
|---|---|
| `Kali Linux` | Kali VM build in Proxmox |
| `Preparing Kali Template Proxmox` | Sanitizing a VM for templating (SSH host keys, machine-id, etc.) so clones come up clean |
| `Windows Server 2019` | Windows Server build with VirtIO drivers |
| `VyOS` | VyOS firewall/router VM build |
| `Proxmox Automation #1 PowerShell` | PowerShell script using the Proxmox API (Corsinvest module) to create linked clones from a template |
| `Proxmox Automation #2` | Course-driven deployment: reads a YAML course definition and a class roster, then provisions per-student VMs into the correct pools and storage |
| `SampleCourse.yaml` | Example course definition file used by the deployment script |

## Red Team Virtualization

Vulnerable lab environments, each documented end to end: build the target, exploit it, and in some cases fix it.

| Lab | Description | Tools |
|---|---|---|
| `AD SMB Relay` | Two-server Active Directory environment with SMB signing disabled, exploited with an NTLM relay for credential access | Responder, impacket-ntlmrelayx, netcat |
| `SQL Injection Lab` | Ubuntu LAMP server with a deliberately vulnerable PHP/MariaDB app behind a VyOS firewall | sqlmap, Apache, PHP, MariaDB |
| `PHP for SQL Lab/` | Source code for the vulnerable web app (login, register, search, admin) | PHP |
| `SQL Prepared Statements` | Remediation: rewriting the vulnerable queries with prepared statements to show the fix | PHP, MySQL |
| `Basic html for DoS` | Simple page used as a target for IIS web server DoS testing | HTML |

## Skills Demonstrated

- Proxmox VE administration, templating, and linked clones
- Infrastructure automation with PowerShell and the Proxmox REST API
- Config-driven provisioning (YAML + roster → per-student VMs)
- Building vulnerable environments for offensive training
- Active Directory attack paths (NTLM relay)
- Web app vulnerabilities and secure coding remediation (SQLi → prepared statements)
