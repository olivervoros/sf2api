<?php

namespace Sf2apiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class NoteControllerTest extends WebTestCase {

  public function testNotes() {
   $noteId = $this->checkPostNote();
   $this->checkGetNote($noteId);
   $this->checkPutNote($noteId);
   $this->checkDeleteNote($noteId);
 }

 protected function checkPostNote() {
   $client = static::createClient();

	// Create a new entry in the database
   $content = $this->getNoteJson();
   $client->request('POST', '/notes.json', array(), array(), array(), $content);
   $response = $client->getResponse();
   $data = json_decode($response->getContent(), true);
   $this->assertEquals('Note1', $data['title']);
   $this->assertEquals(200, $response->getStatusCode(), "Unexpected HTTP status code for POST /notes.json/");
   return $data['id'];
 }

 protected function checkGetNote($noteId = NULL) {
   $client = static::createClient();
   $client->request('GET', "/notes/$noteId.json");
   $response = $client->getResponse();
   $this->assertEquals(200, $response->getStatusCode(), "Unexpected HTTP status code for GET /notes/$noteId.json");

	// Let's try to get a record which does not exists, we expect 404 
	// TODO: This could be done nicer with fixtures...
   $client->request('GET', "/notes/99999999999999.json");
   $response = $client->getResponse();
   $this->assertEquals(404, $response->getStatusCode(), "Unexpected HTTP status code for GET /notes/99999999999999.json");
 }

 protected function checkPutNote($noteId = NULL) {
   $client = static::createClient();
   $updatecontent = $this->getUpdatedNoteJson();
   $client->request('PUT', "/notes/$noteId.json", array(), array(), array(), $updatecontent);
   $response = $client->getResponse();
   $this->assertEquals(200, $response->getStatusCode(), "Unexpected HTTP status code for PUT /notes/$noteId.json");

	// Let's see if the data changed
   $data = json_decode($response->getContent(), true);
   $this->assertEquals('Note1updated', $data['title']);
 }

 protected function checkDeleteNote($noteId = NULL) {
	// Let's try to delete a record which does not exists, we expect 404
   $client = static::createClient();
   $client->request('DELETE', "/notes/99999999999999.json");
   $response = $client->getResponse();
   $this->assertEquals(404, $response->getStatusCode(), "Unexpected HTTP status code for DELETE /notes/99999999999999.json");

	// Let's try to delete a record which we created above, we expect 204
   $client->request('DELETE', "/notes/$noteId.json");
   $response = $client->getResponse();
   $this->assertEquals(204, $response->getStatusCode(), "Unexpected HTTP status code for DELETE /notes/$noteId.json");

	// We deleted the record, so we expect a 404
   $client->request('GET', "/notes/$noteId.json");
   $response = $client->getResponse();
   $this->assertEquals(404, $response->getStatusCode(), "Unexpected HTTP status code for GET /notes/$noteId.json");
 }

 protected function getNoteJson() {
   return '{
    "title": "Note1",
    "description": "Note Description 1"
  }';
}

protected function getUpdatedNoteJson() {
	return '{
    "title": "Note1updated",
    "description": "Note Description 1 updated"
  }';
}

}
