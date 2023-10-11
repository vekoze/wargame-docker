import subprocess

# ANSI color codes
RED = "\033[91m"
GREEN = "\033[92m"
RESET = "\033[0m"

def run(command: str, comment: str, capture: bool = True) -> None:
    print(f"{comment} ... ", end="", flush=True)
    if capture:
        result = subprocess.run(command, capture_output=True)
        if result.returncode == 0:
            print(f"{GREEN}✓{RESET}")
        else:
            print(f"{RED}✕{RESET}")
            print(result.stderr.decode())
    else:
        subprocess.run(command)

print(
"""
 __      __                                           
/  \    /  \_____ _______  _________    _____   ____  
\   \/\/   /\__  \\_  __ \/ ___\__  \  /     \_/ __ \ 
 \        /  / __ \|  | \/ /_/  > __ \|  Y Y  \  ___/ 
  \__/\  /  (____  /__|  \___  (____  /__|_|  /\___  >
       \/        \/     /_____/     \/      \/     \/ 

""")

# Build Docker images
run("docker build -t wargame wargame/", "Build wargame Docker image")
run("docker build -t wapi wapi/", "Build wAPI Docker image")

# Start services using Docker Compose
run("docker-compose up", "Start services using Docker Compose", capture=False)