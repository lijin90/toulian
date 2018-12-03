<?php

/**
 * Openfire REST API
 * 
 * The REST API Plugin provides the ability to manage Openfire by sending an REST/HTTP request to the server.
 * This plugin’s functionality is useful for applications that need to administer Openfire outside of the Openfire admin console.
 * @link http://www.igniterealtime.org/projects/openfire/plugins/restapi/readme.html
 * @author Changfeng Ji <jichf@qq.com>
 */
class OpenfireRestApi {

    /**
     * REST API Host
     * @var string
     * @author Changfeng Ji <jichf@qq.com>
     */
    public $host = 'http://im.toulianwang.com:9090/plugins/restapi/v1';

    /**
     * Shared secret key
     * 
     * To access the endpoints is that required to send the secret key in your header request.
     * The secret key can be defined in Openfire Admin console under Server > Server Settings > REST API.
     * E.g. Header: Authorization: s3cretKey
     * @var string
     * @author Changfeng Ji <jichf@qq.com>
     */
    public $secretKey = 'JWHf2u23k4BuMyGh';

    public function __construct() {
        
    }

    /**
     * @param string $method HTTP request method
     * @param string $endpoint Api request endpoint
     * @param array $params Parameters
     * @return array|false Array with data or error, or False when something went fully wrong
     * @author Changfeng Ji <jichf@qq.com>
     */
    private function doRequest($method, $endpoint, $params = array()) {
        $url = $this->host . $endpoint;
        $header = array(
            'Accept: application/json',
            'Authorization: JWHf2u23k4BuMyGh'
        );
        //初始化curl
        $ch = curl_init();
        //参数设置
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        switch ($method) {
            case 'get':
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                curl_setopt($ch, CURLOPT_HTTPGET, true);
                curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($params));
                break;
            case 'post':
                $header[] = 'Content-Type: application/json';
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                curl_setopt($ch, CURLOPT_POST, true);
                if ($params) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
                }
                break;
            case 'put':
                $header[] = 'Content-Type: application/json';
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($params) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
                }
                break;
            case 'delete':
                $header[] = 'Content-Type: application/json';
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                if ($params) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
                }
                break;
            default:
                return false;
                break;
        }
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return array('httpCode' => $httpCode, 'result' => json_decode($result));
    }

    /* User related REST Endpoints */

    /**
     * Retrieve users - Endpoint to get all or filtered users
     * @param string $search Search/Filter by username. This act like the wildcard search %String%
     * @param string $propertyKey Filter by user propertyKey.
     * @param string $propertyValue Filter by user propertyKey and propertyValue. Note: It can only be used within propertyKey parameter
     * @return array Users
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function getUsers($search = '', $propertyKey = '', $propertyValue = '') {
        $endpoint = '/users';
        $params = array();
        if ($search) {
            $params['search'] = $search;
        }
        if ($propertyKey) {
            $params['propertyKey'] = $propertyKey;
        }
        if ($propertyKey && $propertyValue) {
            $params['propertyValue'] = $propertyValue;
        }
        $result = $this->doRequest('get', $endpoint, $params);
        if ($result['httpCode'] == 200 && isset($result['result']->user)) {
            return is_array($result['result']->user) ? $result['result']->user : array($result['result']->user);
        }
        return array();
    }

    /**
     * Retrieve a user - Endpoint to get information over a specific user
     * @param string $username Exact username
     * @return object User
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function getUser($username) {
        if (!$username) {
            return null;
        }
        $endpoint = '/users/' . $username;
        $result = $this->doRequest('get', $endpoint);
        return $result['httpCode'] == 200 ? $result['result'] : null;
    }

    /**
     * Create a user - Endpoint to create a new user
     * @param array $params User:
     *  - required parameters: username, password
     *  - available parameters: name, email, properties
     * @return boolean TRUE if success; FALSE otherwise.
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function createUser($params) {
        if (!$params) {
            return false;
        }
        $endpoint = '/users';
        $result = $this->doRequest('post', $endpoint, $params);
        return $result['httpCode'] == 201;
    }

    /**
     * Delete a user - Endpoint to delete a user
     * @param string $username Exact username
     * @return boolean TRUE if success; FALSE otherwise.
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function deleteUser($username) {
        if (!$username) {
            return false;
        }
        $endpoint = '/users/' . $username;
        $result = $this->doRequest('delete', $endpoint);
        return $result['httpCode'] == 200;
    }

    /**
     * Update a user - Endpoint to update / rename a user
     * @param string $username Exact username
     * @param array $params User, available parameters: username, password, name, email, properties
     * @return boolean TRUE if success; FALSE otherwise.
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function updateUser($username, $params) {
        if (!$username || !$params) {
            return false;
        }
        $endpoint = '/users/' . $username;
        $result = $this->doRequest('put', $endpoint, $params);
        return $result['httpCode'] == 200;
    }

    /**
     * Retrieve all user groups - Endpoint to get group names of a specific user
     * @param string $username Exact username
     * @return array Groups
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function getUserGroups($username) {
        if (!$username) {
            return array();
        }
        $endpoint = '/users/' . $username . '/groups';
        $result = $this->doRequest('get', $endpoint);
        if ($result['httpCode'] == 200 && isset($result['result']->groupname)) {
            return is_array($result['result']->groupname) ? $result['result']->groupname : array($result['result']->groupname);
        }
        return array();
    }

    /**
     * Add user to group - Endpoint to add user to a group
     * @param string $username Exact username
     * @param string $groupName Exact group name
     * @return boolean TRUE if success; FALSE otherwise.
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function addUserGroup($username, $groupName) {
        if (!$username || !$groupName) {
            return false;
        }
        $endpoint = '/users/' . $username . '/groups/' . $groupName;
        $result = $this->doRequest('post', $endpoint);
        return $result['httpCode'] == 201;
    }

    /**
     * Delete a user from a group - Endpoint to remove a user from a group
     * @param string $username Exact username
     * @param string $groupName Exact group name
     * @return boolean TRUE if success; FALSE otherwise.
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function deleteUserGroup($username, $groupName) {
        if (!$username || !$groupName) {
            return false;
        }
        $endpoint = '/users/' . $username . '/groups/' . $groupName;
        $result = $this->doRequest('delete', $endpoint);
        return $result['httpCode'] == 200;
    }

    /**
     * Lockout a user - Endpoint to lockout / ban the user from the chat server. The user will be kicked if the user is online.
     * @param string $username Exact username
     * @return boolean TRUE if success; FALSE otherwise.
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function lockoutUser($username) {
        if (!$username) {
            return false;
        }
        $endpoint = '/lockouts/' . $username;
        $result = $this->doRequest('post', $endpoint);
        return $result['httpCode'] == 201;
    }

    /**
     * Unlock a user - Endpoint to unlock / unban the user
     * @param string $username Exact username
     * @return boolean TRUE if success; FALSE otherwise.
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function unlockUser($username) {
        if (!$username) {
            return false;
        }
        $endpoint = '/lockouts/' . $username;
        $result = $this->doRequest('delete', $endpoint);
        return $result['httpCode'] == 200;
    }

    /**
     * Retrieve user roster - Endpoint to get roster entries (buddies) from a specific user
     * @param string $username Exact username
     * @return array Roster
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function getUserRoster($username) {
        if (!$username) {
            return array();
        }
        $endpoint = '/users/' . $username . '/roster';
        $result = $this->doRequest('get', $endpoint);
        if ($result['httpCode'] == 200 && isset($result['result']->rosterItem)) {
            return is_array($result['result']->rosterItem) ? $result['result']->rosterItem : array($result['result']->rosterItem);
        }
        return array();
    }

    /**
     * Create a user roster entry - Endpoint to add a new roster entry to a user
     * @param string $username Exact username
     * @param array $params Roster:
     *  - required parameters: jid
     *  - available parameters: nickname, subscriptionType, groups
     * @return boolean TRUE if success; FALSE otherwise.
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function createUserRoster($username, $params) {
        if (!$username || !$params) {
            return false;
        }
        $endpoint = '/users/' . $username . '/roster';
        $result = $this->doRequest('post', $endpoint, $params);
        return $result['httpCode'] == 201;
    }

    /**
     * Delete a user roster entry - Endpoint to remove a roster entry from a user
     * @param string $username Exact username
     * @param string $jid JID of the roster item
     * @return boolean TRUE if success; FALSE otherwise.
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function deleteUserRoster($username, $jid) {
        if (!$username || !$jid) {
            return false;
        }
        $endpoint = '/users/' . $username . '/roster/' . $jid;
        $result = $this->doRequest('delete', $endpoint);
        return $result['httpCode'] == 200;
    }

    /**
     * Update a user roster entry - Endpoint to update a roster entry
     * @param string $username Exact username
     * @param string $jid JID of the roster item
     * @param array $params Roster, available parameters: jid, nickname, subscriptionType, groups
     * @return boolean TRUE if success; FALSE otherwise.
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function updateUserRoster($username, $jid, $params) {
        if (!$username || !$jid || !$params) {
            return false;
        }
        $endpoint = '/users/' . $username . '/roster/' . $jid;
        $result = $this->doRequest('put', $endpoint, $params);
        return $result['httpCode'] == 200;
    }

    /* Chat room related REST Endpoints */

    /**
     * Retrieve all chat rooms - Endpoint to get all chat rooms
     * @param string $servicename The name of the Group Chat Service. Default value: conference
     * @param string $type public: Only as List Room in Directory set rooms. all: All rooms. Default value: public
     * @param string $search Search/Filter by room name. This act like the wildcard search %String%	
     * @return array Chatrooms
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function getChatrooms($servicename = '', $type = '', $search = '') {
        $endpoint = '/chatrooms';
        $params = array();
        if ($servicename) {
            $params['servicename'] = $servicename;
        }
        if ($type) {
            $params['type'] = $type;
        }
        if ($search) {
            $params['search'] = $search;
        }
        $result = $this->doRequest('get', $endpoint, $params);
        if ($result['httpCode'] == 200 && isset($result['result']->chatRoom)) {
            return is_array($result['result']->chatRoom) ? $result['result']->chatRoom : array($result['result']->chatRoom);
        }
        return array();
    }

    /**
     * Retrieve a chat room - Endpoint to get information over specific chat room
     * @param string $roomname Exact room name
     * @return object Chatroom
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function getChatroom($roomname) {
        if (!$roomname) {
            return null;
        }
        $endpoint = '/chatrooms/' . $roomname;
        $result = $this->doRequest('get', $endpoint);
        return $result['httpCode'] == 200 ? $result['result'] : null;
    }

    /**
     * Retrieve chat room participants - Endpoint to get all participants with a role of specified room.
     * @param string $roomname Exact room name
     * @param string $servicename The name of the Group Chat Service. Default value: conference
     * @return array Participants
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function getChatroomParticipants($roomname, $servicename = '') {
        if (!$roomname) {
            return null;
        }
        $endpoint = '/chatrooms/' . $roomname . '/participants';
        $result = $this->doRequest('get', $endpoint);
        if ($result['httpCode'] == 200 && isset($result['result']->participant)) {
            return is_array($result['result']->participant) ? $result['result']->participant : array($result['result']->participant);
        }
        return array();
    }

    /**
     * Retrieve chat room occupants - Endpoint to get all occupants (all roles / affiliations) of a specified room.
     * @param string $roomname Exact room name
     * @param string $servicename The name of the Group Chat Service. Default value: conference
     * @return array Occupants
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function getChatroomOccupants($roomname, $servicename = '') {
        if (!$roomname) {
            return null;
        }
        $endpoint = '/chatrooms/' . $roomname . '/occupants';
        $result = $this->doRequest('get', $endpoint);
        if ($result['httpCode'] == 200 && isset($result['result']->occupant)) {
            return is_array($result['result']->occupant) ? $result['result']->occupant : array($result['result']->occupant);
        }
        return array();
    }

    /**
     * Create a chat room - Endpoint to create a new chat room.
     * @param array $params Chatroom:
     *  - required parameters: roomName, naturalName, description
     *  - available parameters: description, subject, password, creationDate, modificationDate, maxUsers, persistent,
     *        publicRoom, registrationEnabled, canAnyoneDiscoverJID, canOccupantsChangeSubject, canOccupantsInvite,
     *        canChangeNickname, logEnabled, loginRestrictedToNickname, membersOnly, moderated, broadcastPresenceRoles,
     *        owners, admins, members, outcasts, ownerGroups, adminGroups, memberGroups, outcastGroups
     * @param string $servicename The name of the Group Chat Service. Default value: conference
     * @return boolean TRUE if success; FALSE otherwise.
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function createChatroom($params, $servicename = '') {
        if (!$params) {
            return false;
        }
        $endpoint = '/chatrooms';
        $result = $this->doRequest('post', $endpoint, $params);
        return $result['httpCode'] == 201;
    }

    /**
     * Delete a chat room - Endpoint to delete a chat room.
     * @param string $roomname Exact room name
     * @param string $servicename The name of the Group Chat Service. Default value: conference
     * @return boolean TRUE if success; FALSE otherwise.
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function deleteChatroom($roomname, $servicename = '') {
        if (!$roomname) {
            return false;
        }
        $endpoint = '/chatrooms/' . $roomname;
        $result = $this->doRequest('delete', $endpoint);
        return $result['httpCode'] == 200;
    }

    /**
     * Update a chat room - Endpoint to update a chat room.
     * @param string $roomname Exact room name
     * @param array $params User, available parameters: roomName, naturalName, description, description, subject, password, creationDate, modificationDate, maxUsers, persistent, etc,
     * @param string $servicename The name of the Group Chat Service. Default value: conference
     * @return boolean TRUE if success; FALSE otherwise.
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function updateChatroom($roomname, $params, $servicename = '') {
        if (!$roomname || !$params) {
            return false;
        }
        $endpoint = '/chatrooms/' . $roomname;
        $result = $this->doRequest('put', $endpoint, $params);
        return $result['httpCode'] == 200;
    }

    /**
     * Add user with role to chat room - Endpoint to add a new user with role to a room.
     * @param string $roomname Exact room name
     * @param string $name The local username or the user JID
     * @param string $roles Available roles: owners, admins, members, outcasts
     * @param string $servicename The name of the Group Chat Service. Default value: conference
     * @return boolean TRUE if success; FALSE otherwise.
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function addChatroomUser($roomname, $name, $roles, $servicename = '') {
        if (!$roomname || !$name || !$roles) {
            return false;
        }
        $endpoint = '/chatrooms/' . $roomname . '/' . $roles . '/' . $name;
        $result = $this->doRequest('post', $endpoint);
        return $result['httpCode'] == 201;
    }

    /**
     * Add group with role to chat room - Endpoint to add a new group with role to a room.
     * @param string $roomname Exact room name
     * @param string $name The group name
     * @param string $roles Available roles: owners, admins, members, outcasts
     * @param string $servicename The name of the Group Chat Service. Default value: conference
     * @return boolean TRUE if success; FALSE otherwise.
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function addChatroomGroup($roomname, $name, $roles, $servicename = '') {
        if (!$roomname || !$name || !$roles) {
            return false;
        }
        $endpoint = '/chatrooms/' . $roomname . '/' . $roles . '/group/' . $name;
        $result = $this->doRequest('post', $endpoint);
        return $result['httpCode'] == 201;
    }

    /**
     * Delete a user from a chat room - Endpoint to remove a room user role. 
     * @param string $roomname Exact room name
     * @param string $name The local username or the user JID
     * @param string $roles Available roles: owners, admins, members, outcasts
     * @param string $servicename The name of the Group Chat Service. Default value: conference
     * @return boolean TRUE if success; FALSE otherwise.
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function deleteChatroomUser($roomname, $name, $roles, $servicename = '') {
        if (!$roomname || !$name || !$roles) {
            return false;
        }
        $endpoint = '/chatrooms/' . $roomname . '/' . $roles . '/' . $name;
        $result = $this->doRequest('delete', $endpoint);
        return $result['httpCode'] == 200;
    }

    /* System related REST Endpoints */

    /* Group related REST Endpoints */

    /* Session related REST Endpoints */

    /* Message related REST Endpoints */
}
