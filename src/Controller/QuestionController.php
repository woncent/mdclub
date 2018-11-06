<?php

declare(strict_types=1);

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * 问答
 *
 * Class QuestionController
 * @package App\Controller
 */
class QuestionController extends Controller
{
    /**
     * 问答列表页
     *
     * @param  Request  $request
     * @param  Response $response
     * @return Response
     */
    public function pageIndex(Request $request, Response $response): Response
    {
        return $response;
    }

    /**
     * 问答详情页
     *
     * @param  Request  $request
     * @param  Response $response
     * @param  int      $question_id
     * @return Response
     */
    public function pageDetail(Request $request, Response $response, int $question_id): Response
    {
        return $response;
    }

    /**
     * 获取指定用户关注的问题
     *
     * @param  Request  $request
     * @param  Response $response
     * @param  int      $user_id
     * @return Response
     */
    public function getFollowing(Request $request, Response $response, int $user_id): Response
    {
        $following = $this->questionFollowService->getFollowing($user_id, true);

        return $this->success($response, $following);
    }

    /**
     * 获取我关注的问题
     *
     * @param  Request  $request
     * @param  Response $response
     * @return Response
     */
    public function getMyFollowing(Request $request, Response $response): Response
    {
        $userId = $this->roleService->userIdOrFail();
        $following = $this->questionFollowService->getFollowing($userId, true);

        return $this->success($response, $following);
    }

    /**
     * 添加关注
     *
     * @param  Request  $request
     * @param  Response $response
     * @param  int      $question_id
     * @return Response
     */
    public function addFollow(Request $request, Response $response, int $question_id): Response
    {
        $userId = $this->roleService->userIdOrFail();
        $this->questionFollowService->addFollow($userId, $question_id);

        return $this->success($response);
    }

    /**
     * 取消关注
     *
     * @param  Request  $request
     * @param  Response $response
     * @param  int      $question_id
     * @return Response
     */
    public function deleteFollow(Request $request, Response $response, int $question_id): Response
    {
        $userId = $this->roleService->userIdOrFail();
        $this->questionFollowService->deleteFollow($userId, $question_id);

        return $this->success($response);
    }

    /**
     * 获取问答列表
     *
     * @param  Request  $request
     * @param  Response $response
     * @return Response
     */
    public function getList(Request $request, Response $response): Response
    {
        $list = $this->questionService->getList(true);

        return $this->success($response, $list);
    }

    /**
     * 创建问题
     *
     * @param  Request  $request
     * @param  Response $response
     * @return Response
     */
    public function create(Request $request, Response $response): Response
    {
        $userId = $this->roleService->userIdOrFail();

        $questionId = $this->questionService->create(
            $userId,
            $request->getParsedBodyParam('title'),
            $request->getParsedBodyParam('content_markdown'),
            $request->getParsedBodyParam('content_rendered'),
            explode(',', $request->getParsedBodyParam('topic_ids'))
        );

        $questionInfo = $this->questionService->get($questionId, true);

        return $this->success($response, $questionInfo);
    }

    /**
     * 获取一个问题信息
     *
     * @param  Request  $request
     * @param  Response $response
     * @param  int      $question_id
     * @return Response
     */
    public function get(Request $request, Response $response, int $question_id): Response
    {
        $questionInfo = $this->questionService->get($question_id, true);

        return $this->success($response, $questionInfo);
    }

    /**
     * 更新问题
     *
     * @param  Request  $request
     * @param  Response $response
     * @param  int      $question_id
     * @return Response
     */
    public function update(Request $request, Response $response, int $question_id): Response
    {
        return $response;
    }

    /**
     * 删除一个问题
     *
     * @param  Request  $request
     * @param  Response $response
     * @param  int      $question_id
     * @return Response
     */
    public function delete(Request $request, Response $response, int $question_id): Response
    {
        // 暂定只有管理员能删除问题
        $this->roleService->managerIdOrFail();

        $softDelete = !!$request->getQueryParam('soft_delete', 1);

        $this->questionService->delete($question_id, $softDelete);

        return $this->success($response);
    }

    /**
     * 投票
     *
     * @param  Request  $request
     * @param  Response $response
     * @param  int      $question_id
     * @return Response
     */
    public function vote(Request $request, Response $response, int $question_id): Response
    {
        return $response;
    }

    /**
     * 获取指定问题的关注者
     *
     * @param  Request  $request
     * @param  Response $response
     * @param  int      $question_id
     * @return Response
     */
    public function getFollowers(Request $request, Response $response, int $question_id): Response
    {
        $followers = $this->questionFollowService->getFollowers($question_id, true);

        return $this->success($response, $followers);
    }

    /**
     * 获取指定问题下的评论列表
     *
     * @param  Request  $request
     * @param  Response $response
     * @param  int      $question_id
     * @return Response
     */
    public function getComments(Request $request, Response $response, int $question_id): Response
    {
        return $response;
    }

    /**
     * 在指定问题下发表评论
     *
     * @param  Request  $request
     * @param  Response $response
     * @param  int      $question_id
     * @return Response
     */
    public function createComment(Request $request, Response $response, int $question_id): Response
    {
        return $response;
    }
}
