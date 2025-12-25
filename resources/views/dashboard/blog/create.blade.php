.
03363e6
resources\views\dashboard\blog\create.blade.php
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="content" style="font-size: 21px">Content</label>
                                    <textarea name="content" class="form-control" rows="5" required>{{ old('content') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="main_image" style="font-size: 21px">Main Image</label>
                                    <input type="file" name="main_image" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Add Blog</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

