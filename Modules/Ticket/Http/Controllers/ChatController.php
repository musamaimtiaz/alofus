<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Md Abdur Rahaman Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 05-22-2022
 */

namespace Modules\Ticket\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\VendorUser;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Modules\Ticket\Http\Models\Chat;
use Modules\Ticket\Http\Models\Message;
use Modules\Ticket\Http\Requests\MessageRequest;

class ChatController extends Controller
{
    use ApiResponse;

    public function createChat(Request $request)
    {
        if (! $request->vendor_id) {
            return $this->badRequestResponse([], __('Vendor id is required'));
        }
        $request->vendor_id = base64_decode($request->vendor_id);

        $receiver = VendorUser::getVendorAdminId($request->vendor_id);

        $chat = Chat::create([
            'receiver_id' => $receiver->user_id,
            'sender_id' => auth()->id(),
            'thread_key' => 'THRD-' . uniqid(),
        ]);

        $chat->receiver = $receiver;

        return $this->successResponse([
            'title' => view('ticket::pieces.name', compact('chat'))->render(),
            'chatbox' => view('ticket::pieces.shop_feat', compact('chat'))->render(),
            'chat' => $chat,
        ]);
    }

    /**
     * Return the chat conversations
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getConversations(Request $request)
    {
        $chat = Chat::with(['sender:id,name', 'receiver:id,name'])->whereId(base64_decode($request->thread_id))->first();
        if (! $chat) {
            return $this->errorResponse([], 404, __('Chat not found'));
        }

        $chat->messages()->where('receiver_id', auth()->id())->update(['is_read' => 1]);

        $messages = $chat->messages()->with(['sender:id,name', 'receiver:id,name'])->orderBy('id', 'desc')->paginate(10);

        $chat->vendorDetails = $chat->getVendor();

        if ($request->page) {
            return $this->successResponse([
                'html' => view('ticket::pieces.paginated', compact('chat', 'messages'))->render(),
                'message' => $messages,
                'chat' => $chat,
                'link' => $messages->nextPageUrl() ?? 0,
            ]);
        } else {
            return $this->successResponse([
                'html' => view('ticket::pieces.chat', compact('chat', 'messages'))->render(),
                'message' => $messages,
                'chat' => $chat,
            ]);
        }
    }

    /**
     * Store chat message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeMessage(MessageRequest $request)
    {
        $chat = Chat::withSender()->whereId($request->thread_id)->first();

        $chat->vendorDetails = $chat->getVendor();

        $receiverId = $chat->sender_id == auth()->id() ? $chat->receiver_id : $chat->sender_id;

        if ($request->hasFile('attach')) {
            $request->inbox_message = $request->attach->getClientOriginalName();
        }

        $message = Message::create([
            'receiver_id' => $receiverId,
            'sender_id' => auth()->id(),
            'message' => $request->inbox_message,
            'thread_id' => $chat->id,
            'has_attachment' => $request->hasFile('attach') ? 1 : 0,
        ]);

        if ($request->hasFile('attach')) {
            $message->uploadFiles(['isUploaded' => false, 'isSavedInObjectFiles' => true, 'isOriginalNameRequired' => true, 'thumbnail' => false]);
        }

        return $this->successResponse([
            'html' => view('ticket::pieces.single-message', compact('message', 'chat'))->render(),
            'message' => $message,
            'chat' => $chat,
        ]);
    }

    /**
     * Returns updated inbox
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function inboxRefresh(Request $request)
    {
        $chats = Chat::getMyContactListWithLastMessage();
        $unread = Message::totalUnreadMessages();

        return $this->successResponse([
            'users' => view('ticket::pieces.chat-userlist', ['contacts' => $chats, 'active' => $request->cid])->render(),
            'box' => view('ticket::pieces.chat-history')->render(),
            'unread' => $unread,
            'chats' => $chats,
        ]);
    }

    /**
     * Send product details to vendor
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendProductDetails(Request $request)
    {
        $item = Product::where('code', $request->code)->first();

        $vendorId = VendorUser::where('vendor_id', $item->vendor_id)->first()->user_id;

        $messageText = view('ticket::pieces.item_feat', compact('item'))->render();

        $chat = Chat::where('receiver_id', $vendorId)->where('sender_id', auth()->id())->first();

        if (! $chat) {
            $chat = Chat::create([
                'receiver_id' => $vendorId,
                'sender_id' => auth()->id(),
            ]);
        }

        Message::create([
            'receiver_id' => $vendorId,
            'sender_id' => auth()->id(),
            'message' => $messageText,
            'thread_id' => $chat->id,
            'has_attachment' => 0,
        ]);

        $contacts = Chat::getMyContactListWithLastMessage();

        $chats = Chat::getMyContactListWithLastMessage();

        $chat = Chat::with(['sender:id,name', 'receiver:id,name'])->whereId($chat->id)->first();

        if (! $chat) {
            return $this->errorResponse([], 404, __('Chat not found'));
        }

        $chat->messages()->where('receiver_id', auth()->id())->update(['is_read' => 1]);

        $messages = $chat->messages()->with(['sender:id,name', 'receiver:id,name'])->orderBy('id', 'desc')->paginate(10);

        $chat->vendorDetails = $chat->getVendor();

        $active = 'shop_' . $vendorId;

        return $this->successResponse([
            'html' => view('ticket::pieces.chat', compact('chat', 'messages', 'active'))->render(),
            'link' => $messages->nextPageUrl() ?? 0,
            'users' => view('ticket::pieces.chat-userlist', compact('contacts', 'chat'))->render(),
            'chat' => $chat,
            'messages' => $messages,
            'active' => $active,
            'contacts' => $contacts,
        ]);
    }

    /**
     * Initiates chat with vendor
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function initiateChatWithVendor(Request $request)
    {
        $vendor = VendorUser::where('vendor_id', base64_decode($request->code))->first();

        $messageText = '<span class="chat-initiate">Chat initiated.</span>';

        $chat = Chat::where('receiver_id', $vendor->user_id)->first();

        if (! $chat) {
            $chat = Chat::create([
                'receiver_id' => $vendor->user_id,
                'sender_id' => auth()->id(),
            ]);
        }

        $message = Message::where('thread_id', $chat->id)->orderBy('id', 'desc')->first();

        if (! $message) {
            Message::create([
                'receiver_id' => $vendor->user_id,
                'sender_id' => auth()->id(),
                'message' => $messageText,
                'thread_id' => $chat->id,
                'has_attachment' => 0,
            ]);
        }

        $chats = Chat::getMyContactListWithLastMessage();

        $unread = Message::totalUnreadMessages();

        $chat = Chat::with(['sender:id,name', 'receiver:id,name'])->whereId($chat->id)->first();

        if (! $chat) {
            return $this->errorResponse([], 404, __('Chat not found'));
        }

        $chat->messages()->where('receiver_id', auth()->id())->update(['is_read' => 1]);

        $messages = $chat->messages()->with(['sender:id,name', 'receiver:id,name'])->orderBy('id', 'desc')->paginate(10);

        $chat->vendorDetails = $chat->getVendor();

        return $this->successResponse([
            'users' => view('ticket::pieces.chat-userlist', ['contacts' => $chats, 'active' => 'shop_' . $vendor->user_id])->render(),
            'unread' => $unread,
            'link' => $messages->nextPageUrl() ?? 0,
            'box' => view('ticket::pieces.chat', compact('chat', 'messages'))->render(),
            'chats' => $chats,
            'messages' => $messages,
            'active' => 'shop_' . $vendor->user_id,
        ]);
    }
}
