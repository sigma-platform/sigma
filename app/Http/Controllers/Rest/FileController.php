<?php namespace App\Http\Controllers\Rest;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Document;
use App\Models\File;
use App\Http\Requests\FileFormRequest;

class FileController extends Controller {

	/**
	 * Display a listing of the resource for a document.
	 *
	 * @param  int  $documentId
	 * @return Response
	 */
	public function indexForDocument($documentId)
	{
		$document = Document::find($documentId);

		if(!$document)
		{
			return response()->json(
				[
					'success' => false,
					'payload' => [],
					'error' => 'The selected document doesn\'t exist.'
				]
			);
		}

		return response()->json(
			[
				'success' => true,
				'payload' => $document->files,
			]
		);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  FileFormRequest  $request
	 * @return Response
	 */
	public function store(FileFormRequest $request)
	{
		$document = Document::find($request->get('document_id'));
		$filesArray = [];

		foreach($request->file() as $file)
		{
			$filename = File::saveUploadedFile($file, $document);
			$filesArray[] = File::create(array('file' => $filename, 'document_id' => $document->id));
		}

		return response()->json(
			[
				'success' => true,
				'payload' => $filesArray,
				'message' => 'Files successfully added to the document.'
			]
		);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function download($id)
	{
		$file = File::find($id);

		if(!$file)
		{
			return response()->json(
				[
					'success' => false,
					'payload' => [],
					'error' => 'The selected file doesn\'t exist.'
				]
			);
		}

		$document = Document::find($file->document_id);
		$directory = $document->getDocumentDirectory();
		$systemFile = new \Symfony\Component\HttpFoundation\File\File($directory . $file->file);
		$headers = array(
			'Content-Type' => $systemFile->getMimeType()
		);
		return response()->download($directory . $file->file, $file->file, $headers);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$file = File::find($id);

		if(!$file)
		{
			return response()->json(
				[
					'success' => false,
					'payload' => [],
					'error' => 'The selected file doesn\'t exist.'
				]
			);
		}

		$document = Document::find($file->document_id);
		unlink($document->getDocumentDirectory() . $file->file);
		File::destroy($id);

		return response()->json(
			[
				'success' => true,
				'payload' => [],
				'message' => 'File successfully deleted.'
			]
		);
	}

}
