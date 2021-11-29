<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Conversations\V1\Conversation;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Conversations\V1\Conversation\Message\DeliveryReceiptList;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;

/**
 * @property DeliveryReceiptList $deliveryReceipts
 * @method \Twilio\Rest\Conversations\V1\Conversation\Message\DeliveryReceiptContext deliveryReceipts(string $sid)
 */
class MessageContext extends InstanceContext {
    protected $_deliveryReceipts;

    /**
     * Initialize the MessageContext
     *
     * @param Version $version Version that contains the resource
     * @param string $conversationSid The unique ID of the Conversation for this
     *                                message.
     * @param string $sid A 34 character string that uniquely identifies this
     *                    resource.
     */
    public function __construct(Version $version, $conversationSid, $sid) {
        parent::__construct($version);

        // Path Solution
        $this->solution = ['conversationSid' => $conversationSid, 'sid' => $sid, ];

        $this->uri = '/Conversations/' . \rawurlencode($conversationSid) . '/Messages/' . \rawurlencode($sid) . '';
    }

    /**
     * Update the MessageInstance
     *
     * @param array|Options $options Optional Arguments
     * @return MessageInstance Updated MessageInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function update(array $options = []): MessageInstance {
        $options = new Values($options);

        $data = Values::of([
            'Author' => $options['author'],
            'Body' => $options['body'],
            'DateCreated' => Serialize::iso8601DateTime($options['dateCreated']),
            'DateUpdated' => Serialize::iso8601DateTime($options['dateUpdated']),
            'Attributes' => $options['attributes'],
        ]);
        $headers = Values::of(['X-Twilio-Webhook-Enabled' => $options['xTwilioWebhookEnabled'], ]);

        $payload = $this->version->update('POST', $this->uri, [], $data, $headers);

        return new MessageInstance(
            $this->version,
            $payload,
            $this->solution['conversationSid'],
            $this->solution['sid']
        );
    }

    /**
     * Delete the MessageInstance
     *
     * @param array|Options $options Optional Arguments
     * @return bool True if delete succeeds, false otherwise
     * @throws TwilioException When an HTTP error occurs.
     */
    public function delete(array $options = []): bool {
        $options = new Values($options);

        $headers = Values::of(['X-Twilio-Webhook-Enabled' => $options['xTwilioWebhookEnabled'], ]);

        return $this->version->delete('DELETE', $this->uri, [], [], $headers);
    }

    /**
     * Fetch the MessageInstance
     *
     * @return MessageInstance Fetched MessageInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): MessageInstance {
        $payload = $this->version->fetch('GET', $this->uri);

        return new MessageInstance(
            $this->version,
            $payload,
            $this->solution['conversationSid'],
            $this->solution['sid']
        );
    }

    /**
     * Access the deliveryReceipts
     */
    protected function getDeliveryReceipts(): DeliveryReceiptList {
        if (!$this->_deliveryReceipts) {
            $this->_deliveryReceipts = new DeliveryReceiptList(
                $this->version,
                $this->solution['conversationSid'],
                $this->solution['sid']
            );
        }

        return $this->_deliveryReceipts;
    }

    /**
     * Magic getter to lazy load subresources
     *
     * @param string $name Subresource to return
     * @return ListResource The requested subresource
     * @throws TwilioException For unknown subresources
     */
    public function __get(string $name): ListResource {
        if (\property_exists($this, '_' . $name)) {
            $method = 'get' . \ucfirst($name);
            return $this->$method();
        }

        throw new TwilioException('Unknown subresource ' . $name);
    }

    /**
     * Magic caller to get resource contexts
     *
     * @param string $name Resource to return
     * @param array $arguments Context parameters
     * @return InstanceContext The requested resource context
     * @throws TwilioException For unknown resource
     */
    public function __call(string $name, array $arguments): InstanceContext {
        $property = $this->$name;
        if (\method_exists($property, 'getContext')) {
            return \call_user_func_array(array($property, 'getContext'), $arguments);
        }

        throw new TwilioException('Resource does not have a context');
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Conversations.V1.MessageContext ' . \implode(' ', $context) . ']';
    }
}